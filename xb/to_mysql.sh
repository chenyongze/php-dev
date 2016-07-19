!/bin/sh
for ((i=1;i<101;i++))
do
    # echo  "alter table user${i} add column originName varchar(30) NOT NULL DEFAULT '' "  | mysql -uwenba -pwenbatest -P 3307 -h 10.2.1.124 -D liveuser --default-character-set=utf8 -A 
    # echo  "update user${i} SET originName=nickName"  | mysql -uwenba -pwenbatest -P 3307 -h 10.2.1.124 -D liveuser --default-character-set=utf8 -A 

# mysql -uwww -pwww -P 3306 -h 127.0.0.1 -D liveuser --default-character-set=utf8 -A <<EOF
#     alter table user${i} drop column originName;
#     select * from user${i};
# EOF
UPDATE_USER="update  user${i} set originName = nickName;"
SELECT_USER="select * from user${i};"
mysql -uwww -pwww -P 3306 -h 127.0.0.1 -D liveuser --default-character-set=utf8 -A  -e "${UPDATE_USER}${SELECT_USER}"
done


#!/bin/sh
# for ((i=1;i<2;i++))
# do
#     echo "select uid,qq,password from user${i}" | mysql -uwww -pwww -h 127.0.0.1 -D liveuser --default-character-set=utf8
# done

# 方案1 --推荐
# mysql -uwww -pwww -D liveuser -h 127.0.0.1 -e " update  user1 set originName = phoneNo; select * from user1;"
#
# 方案2
# echo "update  user1 set originName = nickName; select * from user1;" | mysql -uwww -pwww  -h 127.0.0.1 -D liveuser --default-character-set=utf8
#
# 方案4
# mysql -uwww -pwww  -h 127.0.0.1 -D liveuser --default-character-set=utf8 << EOF
# alter table user1 add  originName varchar(30) not null default '';
# update  user1 set originName = lastUpdateTime;
# select * from user1;
# EOF
