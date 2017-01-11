# Machine Learning Client

This will be a PHP Client that will define a general API around Machine Learning Service.
 

There will be 2 Initial Services to begin with

  * Sentiment analysis
  * Topic detection

## Sentiment analysis

The API returns a numeric score between 0 and 1. 
Scores close to 1 indicate positive sentiment and scores close to 0 indicate negative sentiment.
Sentiment score is generated using classification techniques. 
The input features of the classifier include n-grams, features generated 
from part-of-speech tags, and word embeddings. English, French, 
Spanish and Portuguese text are supported.


## Topic detection

This is a newly released API that returns the detected topics for a list of submitted 
text records. A topic is identified with a key phrase, which can be one or more related words. 
This API requires a minimum of 100 text records to be submitted, but is designed 
to detect topics across hundreds to thousands of records. Note that this API 
charges 1 transaction per text record submitted. 
The API is designed to work well for short, human-written text such as 
reviews and user feedback.


### Drivers

There will be one driver to use MicroSoft Service and another to use ______


### API

### Sentiment analysis


#### Request Payload

The Driver for this will have send a payload as follows

```json
{
    "documents": [
        {
            "id": "1",
            "text": "This is a really BAD idea"
        },
        {
            "id": "2",
            "text": "This is a really really GOOD idea"
        }
    ]
}
```

##### ID 

This is the id of your document

##### Text

This is the text to consider the intent of 


#### Response Payload

```json
{
    "documents": [
        {
            "id": "1",
            "score": "0.934"
        },
        ...
        {
            "id": "100",
            "score": "0.002"
        },
    ]
}
```

The response is 1 for Positive sentiment close to 0 is negative


#### Limitations

  * maximum size of a single document that can be submitted is 10KB
  * total maximum size of submitted input is 1MB
  * No more than 1,000 documents may be submitted in one call.
  * Language is an optional parameter that should be specified if analyzing non-English text
 
### Installation

Composer install
```
composer require "guzzlehttp/guzzle":"^6.1" "aws/aws-sdk-php":"^3.18"
```

`config/mlservice.php`


```
<?php

return [


    'default' => env('ML_DRIVER', 'mocked'),


    'connections' => [

        'mocked' => [
            'driver' => 'mocked',
            'base_url' => 'https://machine-learning-client.dev/mocked/'
        ],

        'aws' => [
            'driver' => 'aws',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'base_url' => env('AWS_BASE_URL'),
            'ml_id' => env('AWS_ML_ID'),
            'region' => 'us-east-1',
        ],

        'ms' => [
            'driver' => 'ms',
            'key' => env('MS_KEY'),
            'base_url' => env('MS_BASE_URL'),
        ],

    ],


];
```

Add to your `config/app.php`

```
'providers' => [
   
        AlfredNutileInc\MachineLearningClient\MLClientProvider::class,
];

        
'aliases' => [
       
        'MLClient' => \AlfredNutileInc\MachineLearningClient\MLClient::class,
];
```


Then setup your .env as needed for this service 

```
ML_DRIVER=aws
MS_KEY=foo
MS_BASE_URL=https://westus.api.cognitive.microsoft.com

AWS_SECRET_ACCESS_KEY=bar
AWS_ACCESS_KEY_ID=foo
AWS_DEFAULT_REGION=us-east-1
AWS_BASE_URL=https://realtime.machinelearning.us-east-1.amazonaws.com
AWS_ML_ID="ml-ZKR0sJWQtbm"

GOOGLE_APPLICATION_CREDENTIALS=foo
GCLOUD_PROJECT=ml-sentiment-v1
GOOGLE_BASE_URL=https://speech.googleapis.com/v1beta1

```