#!/bin/bash
curl -k "http://localhost/itnerd/scriptjes/warehouse" -o result_warehouse.txt
curl -k "http://localhost/itnerd/scriptjes/item" -o result_item.txt
curl -k "http://localhost/itnerd/scriptjes/itemfingoods" -o result_itemfingoods.txt
curl -k "http://localhost/itnerd/scriptjes/itemwhbal" -o result_itemwhbal.txt
curl -k "http://localhost/itnerd/scriptjes/producttype" -o result_producttype.txt
curl -k "http://localhost/itnerd/scriptjes/warehousetype" -o result_warehousetype.txt
curl -k "http://localhost/itnerd/scriptjes/itemfingoodsmax" -o result_itemfingoodsmax.txt
curl -k "http://localhost/itnerd/scriptjes/itemmax" -o result_itemmax.txt
curl -k "http://localhost/itnerd/scriptjes/productlist" -o result_productlist.txt
curl -k "http://localhost/itnerd/scriptjes/numberwatch_warehouse" -o result_numberwatchWH.txt