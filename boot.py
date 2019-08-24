#boot.py esp8266


# This file is executed on every boot (including wake-boot from deepsleep)

#import esp

#esp.osdebug(None)

print('booting')

import uos, machine

#uos.dupterm(None, 1) # disable REPL on UART(0)

import gc

#import webrepl

#webrepl.start()

gc.collect()


import project

pwm_led()



