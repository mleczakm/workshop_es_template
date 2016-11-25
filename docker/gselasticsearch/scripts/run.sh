echo "cluster.name: $CLUSTER_NAME" >> /etc/elasticsearch/elasticsearch.yml
/etc/init.d/elasticsearch start
echo "Update certificates and install plugins"
update-ca-certificates -f
/usr/share/elasticsearch/bin/plugin install polyfractal/elasticsearch-inquisitor
/opt/kibana/bin/kibana

/bin/bash