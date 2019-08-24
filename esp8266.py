
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

#esp8266  d8 = pin 15    d6 =12

import dht, machine,time,utime

d = dht.DHT11(machine.Pin(12))


def temp_hum():

  d.measure()
  temp = d.temperature()
  hum = d.humidity()
  
  return temp, hum

print(temp_hum())





def barmeter():
 
  from bmp280 import BMP280
  try:
    bus = machine.I2C(sda=machine.Pin(4),scl=machine.Pin(5))
    bmp = BMP280(bus)
   
    print(bmp.temperature)
    print(bmp.pressure)
  except:
    print('bar meter error reading ')
  
  
def led():

  p2 = machine.Pin(2, machine.Pin.OUT)
  for i in range(100):
    p2.value(1)
    time.sleep(1)
    p2.value(0)
    
    
    
    
    
def pwm_led():   

  p2 = machine.Pin(2)
  pwm2 = machine.PWM(p2)
  pwm2.freq(500)
  while True:
      for duty in range(0,1023,80):
          pwm2.duty(duty)
          utime.sleep_ms(150)
      for duty in range(1023, 0,-80):
          pwm2.duty(duty)
          utime.sleep_ms(150)
          
        
  
  
        
pwm_led()
  
barmeter()


  
 
