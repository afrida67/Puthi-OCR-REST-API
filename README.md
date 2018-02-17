# Puthi OCR REST API Documentation  
## 1.Image Upload:  
Endpoint: http://puthi-ocr.com/upload or http://10.101.0.154/upload


## Description:  
API endpoint for uploading image file. Upload images using this endpoint.

## Technical Details:

**Request type** : POST

**Authorization** : NoAuth

**Headers** : null

**Body** : form-data

**Key** : "sampleFile"
	
  **Value** : the image file itself
	
On successful upload you will get the corresponding filename (unique for every upload) to use for further OCR operation using the other API endpoints.  
## 2. OCR Operation:

Endpoint: http://puthi-ocr.com/do_ocr  or http://10.101.0.154/do_ocr 

## Description:  
API endpoint for OCR operation. Build a query string using the unique filename (received in response of uploading the image).

## Technical Details:  

**Request type**: GET

**Authorization** : NoAuth

**Sample query string** : http://puthi-ocr.com/do_ocr?src=-KqSQMdW5BQmWwUO6gAy.jpg

Here, "-KqSQMdW5BQmWwUO6gAy.jpg" is the unique file name that you have got in response after uploading the image file.

**Get Postman Collection at** : https://goo.gl/SfZpkP

## Uploaded image restriction for do_ocr:

Image must be 300dpi

Plane and simple image with bangla content without any row-column 

This API only support bangla optical character recognition 

Image format png jpg 

