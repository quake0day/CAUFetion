import MySQLdb
import os,sys
import re
from time import sleep


def loadInfo():
	try:
			conn =  MySQLdb.connect(host='localhost',user='root',passwd='chensi',db='chensi')
	except Exception, e:
			print e
			sys.exit()
	cur = conn.cursor()
	cur2 = conn.cursor()
	cur3 = conn.cursor()
	sql = "SELECT * FROM  `signup` WHERE  `set` =0 LIMIT 0 , 30"
	cur.execute(sql)
	cur2.execute(sql)
	cur3.execute(sql)
	len_t = len(cur.fetchall())
	print len_t
	cur.close()
	i = 0
	if len_t != 0:
		for i in range(len_t):
			res = cur2.fetchone()
			cur2.close()
			userid = res[1]
			passwd = res[2]
			tel = res[3]
			telpasswd = res[4]
			create_f = setToCron(userid,passwd,tel,telpasswd)
			if create_f == True:
			   updatewk = "UPDATE `chensi`.`signup` SET `set` = 1 where userid= "+ res[1] #when up to return True then change database "0" to "1"
			   cur3.execute(updatewk)    
			   cur3.close() 
			   i+=1
	
	 
	


def setToCron(username,password,tel,telpasswd):
    #*/10 7-19 * * * /usr/bin/python /home/quake0day/Fetion/num1.py
	dust1 = '*/1 7-22 * * * '
	dust2 = '/usr/bin/python '
	dust3 = '/home/chensi/caufetion/scoreScanner.py '
	dust4 = ' ' + username + ' ' + password + ' ' + tel + ' ' + telpasswd
	dust = dust1 + dust2 + dust3 + dust4 + "\n"

	com0 = 'sudo chmod 777 /var/spool/cron/quake0day'
	str0 = os.popen(com0)

	newfile = open('/var/spool/cron/quake0day','a')
	newfile.write(dust)
	newfile.close()

	## sed '1r ss' 121
	#com1 = 'sed \'1r ttt\' ' +username +  " > ttt"
	#print com1

	#str1 = os.popen(com1)
	#com2 = 'crontab ttt'   
	#str2 = os.popen(com2)

	
	return True 

#setToCron('0607040103','871214','15901030100','lara4cs')
while(1):
	loadInfo()
	sleep(5)
