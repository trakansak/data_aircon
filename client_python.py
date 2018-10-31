import time
from zeep import Client
import xml.etree.ElementTree as ET
from lxml import etree


client = Client('https://127.0.0.1/data-aircon/server.php?wsdl')

# InsertDataAirCon
# client.service.InsertDataAirCon(room = "88",temp = "25",time = "12:00 AM")

# QueryDataAirCon
# res = client.service.QueryDataAirCon()

# QueryforPersonal
# res = client.service.showPersonal()

# InsertProduct
# client.service.addProduct(name="Trakansak", address="674/31", weight="20")
# DeliveredProduct
client.service.confirmProduct('id_product'= 1598);


