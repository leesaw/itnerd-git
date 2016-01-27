#!/bin/bash
curl -k "http://localhost/itnerd-git/scriptjes/warehouse" -o result_warehouse.txt
curl -k "http://localhost/itnerd-git/scriptjes/item" -o result_item.txt
curl -k "http://localhost/itnerd-git/scriptjes/itemfingoods" -o result_itemfingoods.txt
curl -k "http://localhost/itnerd-git/scriptjes/itemwhbal" -o result_itemwhbal.txt
curl -k "http://localhost/itnerd-git/scriptjes/producttype" -o result_producttype.txt
curl -k "http://localhost/itnerd-git/scriptjes/warehousetype" -o result_warehousetype.txt
curl -k "http://localhost/itnerd-git/scriptjes/itemfingoodsmax" -o result_itemfingoodsmax.txt
curl -k "http://localhost/itnerd-git/scriptjes/itemmax" -o result_itemmax.txt
curl -k "http://localhost/itnerd-git/scriptjes/productlist" -o result_productlist.txt
curl -k "http://localhost/itnerd-git/scriptjes/numberwatch_warehouse" -o result_numberwatchWH.txt
curl -k "http://localhost/itnerd-git/scriptjes/pos_invoice" -o result_pos_invoice.txt
curl -k "http://localhost/itnerd-git/scriptjes/pos_invoicedetail" -o result_pos_invoicedetail.txt