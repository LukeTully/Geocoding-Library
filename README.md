# Geocoding-Library
A tiny library I wrote in an attempt cleanse a medium size list of unstructured and incomplete addresses, as well as subsequently leverage a webservice to gather more information associated with these addresses.

#Sanitizer
Contains functions for identifying various types of address such as postal codes. The address list I as dealing with at the time contained many addresses that were formatted like crap and I needed an automated way to determine valididity before trying to gather more info on them.

#Geocoder
Basically a simple Bing geocoding service client wrapper. I choose Bing at the time for its accuracy, low cost, and ability to do batch processing.
