<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;
use Google\Service\Sheets\BatchUpdateSpreadsheetRequest;
use Google\Service\Sheets\Request;

class GoogleSheetsService
{
    protected $client;
    protected $service;
    protected $spreadsheetId;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuthConfig(config('services.google.service_account_json'));
        $this->client->addScope(Sheets::SPREADSHEETS);
        $this->service = new Sheets($this->client);
    }

    // **ডাইনামিক শিট আইডি সেট করুন**
    public function setSheetId(string $type)
    {
        $sheetIds = config('services.google.sheet_id'); // Config থেকে সব শিট আইডি নিয়ে আসা
        $this->spreadsheetId = $sheetIds[$type] ?? null; // নির্দিষ্ট টাইপের শিট আইডি সেট করা

        if (!$this->spreadsheetId) {
            throw new \Exception("Invalid Sheet Type: {$type}");
        }
    }

    // **নতুন ডাটা যুক্ত করুন (Append Row)**
    public function appendRow(string $type, string $sheetName, array $values)
    {
        $this->setSheetId($type); // শিট আইডি সেট করুন
        $range = "{$sheetName}!A:G";
        $body = new ValueRange(['values' => [$values]]);
        $params = ['valueInputOption' => 'RAW'];

        return $this->service->spreadsheets_values->append($this->spreadsheetId, $range, $body, $params);
    }

    // **Google Sheets থেকে সব ডাটা নিয়ে আসুন (Fetch Rows)**
    public function getRows(string $type, string $sheetName)
    {
        $this->setSheetId($type);
        $range = "{$sheetName}!A:G";
        $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);
        return $response->getValues() ?? [];
    }

    // **নির্দিষ্ট রো আপডেট করুন (Update Row)**
    public function updateRow(string $type, string $range, array $values)
    {
        $this->setSheetId($type);
        //dd("Requested Deletion Row Index:", $type);
        $body = new ValueRange(['values' => [$values]]);
        $params = ['valueInputOption' => 'RAW'];

        return $this->service->spreadsheets_values->update($this->spreadsheetId, $range, $body, $params);
    }

    // **নির্দিষ্ট রো ডিলিট করুন (Delete Row)**
    public function deleteRow(string $type, int $rowIndex)
    {
        $this->setSheetId($type);
        //dd("Requested Deletion Row Index:", $rowIndex);
        $requests = [
            new Request([
                'deleteDimension' => [
                    'range' => [
                        'sheetId' => 0, // Default Sheet ID (প্রয়োজনে পরিবর্তন করুন)
                        'dimension' => 'ROWS',
                        'startIndex' => $rowIndex - 1, // 0-based index
                        'endIndex' => $rowIndex, // শুধুমাত্র ১টি রো ডিলিট করা হবে
                    ],
                ],
            ]),
        ];

        $batchUpdateRequest = new BatchUpdateSpreadsheetRequest(['requests' => $requests]);

        return $this->service->spreadsheets->batchUpdate($this->spreadsheetId, $batchUpdateRequest);
    }
}
