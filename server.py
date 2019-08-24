

#esp8266  server.py  
#show temperature and humidity 


import dht,machine ,time  
from bmp280 import BMP280


bus = machine.I2C(sda=machine.Pin(21),scl=machine.Pin(22))
bmp = BMP280(bus)



d = dht.DHT11(machine.Pin(16))  # pin 16 = g16 esp32


html = """<!DOCTYPE html>
<html>
    <head> <title>ESP8266 Pins</title>   <meta http-equiv="refresh" content="5">
</head>
    <body> <h1>ESP8266 Pins</h1>
        <table border="1"> <tr><th>Temperature</th><th>Humidity</th></tr> %s </table>

"""

html1 = """
        <table border="1"> <tr><th>Temperature</th><th>Barmeter</th></tr> %s </table>
    </body>
 
</html>
"""


import socket
addr = socket.getaddrinfo('0.0.0.0', 80)[0][-1]

s = socket.socket()
s.bind(addr)
s.listen(1)

print('listening on', addr)

while True:
    cl, addr = s.accept()
    print('client connected from', addr)
    cl_file = cl.makefile('rwb', 0)
    while True:
        line = cl_file.readline()
        if not line or line == b'\r\n':
            break
    time.sleep(2)        
    d.measure()
    temperature,humidity  = d.temperature() , d.humidity()
    rows = ['<tr><td>%s</td><td>%d</td></tr>' % (temperature,humidity)]
    rows1 = ['<tr><td>%s</td><td>%d</td></tr>' % (bmp.temperature,bmp.pressure)]


  
    response = html % '\n'.join(rows)+html1 % '\n'.join(rows1)
    print(time.localtime())
   
    cl.send(response)
    cl.close()








