import os 
import time 
import MySQLdb
import re
import os,sys
from time import sleep

def select_id_which_mayNeedSMS():
	try:
			conn =  MySQLdb.connect(host='localhost',user='root',passwd='chensi',db='chensi')
	except Exception, e:
				print e
				sys.exit()
	cur = conn.cursor()
	cur2 = conn.cursor()
	sql = "SELECT * FROM  `signup` WHERE  `set` =0 LIMIT 0 , 30"
	cur.execute(sql)
	cur2.execute(sql)
	len_t = len(cur.fetchall())
	cur.close()
	i = 0
	if len_t != 0:
		for i in range(len_t):
			res = cur2.fetchone()
			
			#if res[j] != None:
				#j++
				#if j !=5
				#continue
			userid = res[1]
			passwd = res[2]
			tel = res[3]
			telpasswd = res[4]
			dust1 = '/usr/bin/python /home/chensi/caufetion/scoreScanner.py'
			dust2 = ' ' + userid +' '+ passwd + ' ' + tel + ' ' + telpasswd
			dust = dust1 + dust2
			print dust
			str0 = os.popen(dust)
		
			i+=1
				
def main():
	while 1: 
		select_id_which_mayNeedSMS()
		time.sleep(60 * 1) 
		

if '__main__' ==__name__:
	main()

