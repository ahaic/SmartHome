
=============#wifi.py=============

import network
wlan = network.WLAN(network.STA_IF)
wlan.active(True)
wlan.scan()
wlan.isconnected()
wlan.connect('WIFI 热点', '密码')
wlan.config('mac')
wlan.ifconfig()
print(wlan)


=============#project.py=============

# for esp8266  25 aug 2019 

#esp8266  d8 = pin 15  

import dht, machine,time
d = dht.DHT11(machine.Pin(15))


def temp_hum():

  d.measure()
  temp = d.temperature()
  hum = d.humidity()
  
  return temp, hum

#print(temp_hum())





def barmeter():
 
  from bmp280 import BMP280
  bus = machine.I2C(sda=machine.Pin(21),scl=machine.Pin(22))
  bmp = BMP280(bus)
   
  print(bmp.temperature)
  print(bmp.pressure)
  
  
def led():

  p2 = machine.Pin(2, machine.Pin.OUT)
  p2.value(1)
  time.sleep(1)
  p2.value(0)
  
for i in range(100):
  led()
  
  
 
