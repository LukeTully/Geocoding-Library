# Geocoding-Library
A tiny library I wrote (Quite some time ago) in an attempt cleanse a small size (~10000) list of unstructured and incomplete addresses, as well as subsequently leverage a webservice to gather more information associated with these addresses. I have not updated the code in about 2 years.

#Sanitizer
Contains functions for identifying various types of address such as postal codes. The address list I was dealing with at the time contained many addresses that were formatted like crap and I needed an automated way to determine validity before trying to gather more info on them.

#Geocoder
A wrapper class for the Bing geocoding webservice. I choose Bing at the time for its accuracy, low cost (free for the size of the dataset), and ability to do batch processing.
