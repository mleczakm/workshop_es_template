def isNoneMatch = { 'none' };
def isFullMatch = { 'full-match' };
def isPartialMatch = { 'partial-match' };

def getMatching = { profileValue, searchFormValue, fieldType ->
	if(profileValue) {
    	return profileValue <= searchFormValue ? isFullMatch() : isNoneMatch();
	}
	return isNoneMatch();
};

def isFullOrPartialMatch = { fieldDetailSize, hits ->
    return (fieldDetailSize > 0 && hits == fieldDetailSize ? isFullMatch() :
        (hits > 0 && hits < fieldDetailSize ? isPartialMatch() : isNoneMatch()));
};

def isNotNestedField  = { fieldDetails ->
    return 'false' == fieldDetails.nested;
};

def getNestedMatching = { fields, fieldType, source ->
    def matching = isNoneMatch();
	// Count matched search conditions
	def hits = 0;

	// if those are not skills, than it's simple
	if(fieldType != 'skills' && fieldType != 'language_skills' && fieldType != 'experience_industry_ids') {
		fields = fields.first();
		for (fieldDetail in fields) {
			if (null != (values = source.extractValue(fieldDetail.path))) {
				if(fieldDetail.val.toString().isInteger()) {
					for(value in values) {
						if(fieldDetail.val.toString().toInteger() == value) {
							hits += 1;
							break
						}
					}
				} else {
					for(value in values) {
						value = value.toString().toLowerCase();
						fieldDetailval = fieldDetail.val.toString().toLowerCase();
						if(fieldDetailval == value || value.contains(fieldDetailval)) {
							hits += 1;
							break
						}
					}
				}
			}
		}
	} else {
		def isSourceExtractedValueMapCreated = false;
		Map sourceExtractedValues = { [:].withDefault{ owner.call() } }()
		fields.each { fieldDetails ->
			// Create map of fields to be able to compare them as whole
			if(isSourceExtractedValueMapCreated == false) {
				for (fieldDetail in fieldDetails) {
					def sourceExtractedIndex = 0;
					if (null != (values = source.extractValue(fieldDetail.path))) {
						def path = fieldDetail.path;
						for(value in values) {
							sourceExtractedValues.(sourceExtractedIndex.toString()).(path.toString()) = value;
							sourceExtractedIndex += 1;
						}
					}
				}
				isSourceExtractedValueMapCreated = true;
			}

			if(isSourceExtractedValueMapCreated == true && sourceExtractedValues.size() > 0) {
				sourceExtractedValues.any { key, extractedValue ->
					def matchesInField = 0;
					for (fieldDetail in fieldDetails) {
						extractedValueField = extractedValue.(fieldDetail.path.toString());
						if(fieldDetail.val.toString().isInteger()) {
							fieldDetailVal = fieldDetail.val.toInteger();
							if(fieldType == 'skills' || fieldType == 'language_skills' || fieldDetail.path.toString() == 'years_of_exp.months') {
								if(fieldDetailVal <= extractedValueField) {
									matchesInField += 1;
								}
							} else {
								if(fieldDetailVal == extractedValueField) {
									matchesInField += 1;
								}
							}
						} else {
							extractedValueField = extractedValueField.toLowerCase();
							fieldDetailval = fieldDetail.val.toString().toLowerCase();
							if(extractedValueField == fieldDetailval || extractedValueField.contains(fieldDetailval)) {
								matchesInField += 1;
							}
						}
					}
					if(matchesInField == extractedValue.size()) {
						hits += 1;
						return true;
					}
				}
			}
		}
	}
	matching = isFullOrPartialMatch(fields.size(), hits);

    return matching;
};

def matching = [:];
for (field in fields) {
    if (isNotNestedField(fieldDetails[field])) {
        matching.put(field, getMatching(_source.extractValue(fieldDetails[field].path),
            fieldDetails[field].val, field));
    } else {
        matching.put(field, getNestedMatching(fieldDetails[field], field, _source));
    }
}

return matching;