sed -i '/</d' $file1
sed -i '1,8d' $file1
sed -i /^$/d $file1
sed -i '/\<0/d' $file1
sed -i '/\<8[0-9]/d' $file1
sed -i '/\<11/d' $file1
sed -i '/\<9[0-9]/d' $file1
sed -i '/[必选]修/d' $file1
sed -i '/任选/d' $file1
sed -i s/[[:space:]]//g $file1
sed -i '/[a-z,A-Z]/d' $file1
sed -i ':a;N;s/\n/\t/;ba;' $file1
sed -i s/[[:space:]]/\#/g $file1
sed -i 's/[#][#]*/\#/g' $file1
cat $file1
