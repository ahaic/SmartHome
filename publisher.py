


#esp32/publisher.py

def publisher():
  
  from umqtt.simple import MQTTClient
  import time,network

  from project import d

  from machine import Pin



  SERVER = '149.28.147.236'
  CLIENT_ID = 'esp8266 - A' # 客户端的ID
  TOPIC1 = b'temperature' # TOPIC的ID
  TOPIC2 = b'humidity' # TOPIC的ID

  led = machine.Pin(2, machine.Pin.OUT)


  try:
    client = MQTTClient(CLIENT_ID, SERVER)
  except:
    print('network error')
    
    
  client.connect()


  while True:
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
      
 





