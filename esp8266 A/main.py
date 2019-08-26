
from umqtt.simple import MQTTClient
import time,network

import dht, machine


def wifi_connect():
    wifi = network.WLAN(network.STA_IF)
    wifi.active(True)
    if not wifi.isconnected():
        print('connecting to network...')
        wifi.connect('Happiness', 'xxxxx')
        while not wifi.isconnected():
            pass
    print('network config:', wifi.ifconfig())



wifi_connect()

led = machine.Pin(2, machine.Pin.OUT)

led.off()
time.sleep(3)
led.on()


#esp32/publisher.py

def publisher():
  
  from umqtt.simple import MQTTClient
  import time,network



  import dht, machine


  SERVER = '149.28.147.236'
  CLIENT_ID = 'esp8266 - A' # 客户端的ID
  TOPIC1 = b'temperature' # TOPIC的ID
  TOPIC2 = b'humidity' # TOPIC的ID



  try:
    client = MQTTClient(CLIENT_ID, SERVER)
  except:
    print('network error')
    machine.reset()
    
    
  client.connect()
  



  while True:
      d = dht.DHT11(machine.Pin(12))

      d.measure()
      temp = d.temperature()
      hum = d.humidity()
      print(temp,hum)
      
      led.off()
      time.sleep(0.5)
      led.on()
      
      client.publish(TOPIC2, str(hum))
      client.publish(TOPIC1, str(temp))
      
      
      print('publised @ ',time.time())
      time.sleep(5)
      
publisher()






