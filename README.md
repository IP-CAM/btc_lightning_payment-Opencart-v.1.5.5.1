Author: khita.org
Telegram Contact: https://t.me/pavlowd
License: GNU General Public License version 3 (GPLv3)

This is payment gateway for Bitcoin Lightning Network users who have running own LN node.
You need to have open lnd REST API port to use this module.
Module use invoice.macaroon hex for invoice generation.

Here you can try demo:

[b]Opencart 1.5.5.1 [/b]
https://demo-oc1564.khita.org/
https://demo-oc1564.khita.org/admin/
demo;demo

[b]Opencart 2.1.0.2 [/b]
https://demo-oc2102.khita.org/
https://demo-oc2102.khita.org/admin/
demo;demo

[b]Opencart 3.0.2.0[/b]
https://demo-oc3020.khita.org/
https://demo-oc3020.khita.org/admin/
demo;demo

Bitcoin Lightning Network is on development now, so be careful, you can lost your BTC. 

Module is free, but I`ll be happy to receive donations ;)
Please leave feedback, what would you like to see in new version.
Donate: 32t6RyByH4qzRoKotawBVCUbmSxGRt2x1f
https://tippin.me/@pavlowd

===========================================================================================
===========================================================================================

Installation

1. 
Opencart 1.5.5.1 - unzip module, upload to store root directory
Opencart 2.1.0.2 - You can unzip/upload content or use ocmod to install module.
Opencart 3.0.2.0 - You can unzip/upload content or use ocmod to install module.

2. Install module "Bitcoin Payment" in Extension > Payment.
3. Edit module configuration, and save changes.
If you don't see module on Payments page, make sure that you have rights to edit module in System > User Permissions > Administrator


To get macaroon.invoice hex use
[code]xxd -ps -u -c 1000  /home/bitcoin/.lnd/data/chain/bitcoin/mainnet/invoice.macaroon[/code]
command

How to allow REST API requests to your Lightning Node:
https://github.com/robclark56/RaspiBolt-Extras/blob/master/RBE_REST_WAN.md
