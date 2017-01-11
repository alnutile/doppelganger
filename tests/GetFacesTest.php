<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;

class GetFacesTest extends TestCase
{
    /**
     * @test
     */
    public function test_sentiment_api()
    {

        $client = new \AlfredNutileInc\MachineLearningClient\Drivers\MicrosoftCognitiveServices();

        $payload = json_decode(file_get_contents(__DIR__ . '/../tests/fixtures/sentiment_payload.json'), true);

        $payload = new \AlfredNutileInc\MachineLearningClient\DTOs\SentimentDTO($payload);

        $results = $client->sentimentRequest($payload);

        dd($results);
    }

    /**
     * @test
     */
    public function test_faces()
    {
        $client = new \AlfredNutileInc\MachineLearningClient\Drivers\MicrosoftCognitiveServices();


        //First get the face
        //dropbox me
        //$face = 'https://dl.dropboxusercontent.com/s/yico3apxa2frpjz/me_2.jpeg';

        $payload = json_decode(File::get(base_path('tests/fixtures/face_id.json')), true);

        $face_id = $payload['faceId'];

        //$results = $client->faceDetect($payload);

        $payload = [
            'faceId' => $face_id,
            "faceListId" => "sample_list",
            "maxNumOfCandidatesReturned" => 10,
            "mode" => "matchPerson"
        ];

        $results = $client->faceSimilar($payload);

        dd($results);
    }

    /**
     * @test
     */
    public function bulk_populate_faces() {


        $directories = File::directories(__DIR__ . '/../../faces/');

        foreach($directories as $path) {

            $faces = File::files($path);

            //Put where?
            //How to track it
            //then how to share it back to the list in one swoop?
            $file = collect($faces)->first();
            $name = File::basename($file);
            File::copy($file, public_path('faces/' . File::name($name)));

        }
    }
}
