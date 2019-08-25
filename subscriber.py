#esp32/subscriber.py


from umqtt.simple import MQTTClient
import time

SERVER = '149.28.147.236'
CLIENT_ID = 'ESP8266 - A'
TOPIC = b'tem_hum'

def mqtt_callback(topic, msg):
    print('topic: {}'.format(topic))
    print('msg: {}'.format(msg))


client = MQTTClient(CLIENT_ID, SERVER)
client.set_callback(mqtt_callback)
client.connect()

client.subscribe(TOPIC)


while True:
    # 查看是否有数据传入
    # 有的话就执行 mqtt_callback
    client.check_msg()
    time.sleep(1)
