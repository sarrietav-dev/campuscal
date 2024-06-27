#!/bin/sh
/usr/bin/mc config host add myminio ${AWS_ENDPOINT} ${AWS_ACCESS_KEY_ID} ${AWS_SECRET_ACCESS_KEY};
# /usr/bin/mc rm -r --force myminio/${AWS_BUCKET};
# /usr/bin/mc rm -r --force myminio/${AWS_BUCKET_PRIVATE};
/usr/bin/mc mb -p myminio/${AWS_BUCKET};
/usr/bin/mc policy set download myminio/${AWS_BUCKET};
/usr/bin/mc policy set public myminio/${AWS_BUCKET};
/usr/bin/mc anonymous set upload myminio/${AWS_BUCKET};
/usr/bin/mc anonymous set download myminio/${AWS_BUCKET};
/usr/bin/mc anonymous set public myminio/${AWS_BUCKET};
exit 0;
