#!/bin/bash
#
# Run this from the Effulgent directory; there's no real point keeping ZendFramework-1.8.2 in the repository, so
# pull it in on the fly from the Zend website.
#
# @author Rob Howard <damncabbage@gmail.com>
#

if [ -d "./tmpdownload" ]; then
	echo "WARNING: tmpdownload already exists!"
	exit
fi

mkdir tmpdownload
pushd tmpdownload
	wget http://framework.zend.com/releases/ZendFramework-1.8.2/ZendFramework-1.8.2-minimal.tar.gz -O zf.tar.gz
	tar -xvzf zf.tar.gz
	mv ZendFramework-1.8.2-minimal/library/Zend ../app/lib/
popd
rm -rf tmpdownload
