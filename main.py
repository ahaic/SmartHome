


def wifi_connect():
    import network
    wifi = network.WLAN(network.STA_IF)
    wifi.active(True)
    if not wifi.isconnected():
        print('connecting to network...')
        wifi.connect('XXX', 'XXXX')
        while not wifi.isconnected():
            pass
    print('network config:', wifi.ifconfig())



wifi_connect()


import publiser



print('-----initialied ----')
