Author: Pavlowd  
Telegram Contact: https://t.me/pavlowd  
Website: https://khita.org  
License: GNU General Public License version 3 (GPLv3)  
  
This is Bitcoin Lightning Network payment gateway for Opencart, that might be used by users who have running own LN node.   
You need to have open lnd REST API port to use this module.  
Module use invoice.macaroon hex for invoice generation.  
  
Here you can try demo:  

https://demo-oc1564.khita.org/  
https://demo-oc1564.khita.org/admin/  
demo;demo  
  
Bitcoin Lightning Network is on development now, so be careful, you can lost your BTC.   
  
Module is free, but I`ll be happy to receive donations ;)  
Please leave feedback, what would you like to see in new version.  
Donate: 32t6RyByH4qzRoKotawBVCUbmSxGRt2x1f  
https://tippin.me/@pavlowd  

  
---------------------------

  
**Installation**

1. unzip module, upload to store root directory
2. Install module "Bitcoin Payment" in Extension > Payment.
3. Edit module configuration, and save changes.  
If you don't see module on Payments page, make sure that you have rights to edit module in System > User Permissions > Administrator  
  

To get macaroon.invoice hex use  
`xxd -ps -u -c 1000  /home/bitcoin/.lnd/data/chain/bitcoin/mainnet/invoice.macaroon`  
command  
  
How to allow REST API requests to your Lightning Node:  
https://github.com/robclark56/RaspiBolt-Extras/blob/master/RBE_REST_WAN.md  
