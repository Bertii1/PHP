<?php
  $regioniPath = 'comuni.json';

  if (!file_exists($regioniPath)) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(404);
    echo json_encode(['error' => 'File not found']);
    exit;
  }

  // Return JSON with proper headers. Allowing all origins is convenient for
  // local development; when deploying to production scope this to the
  // specific domain(s) you trust.
  header('Content-Type: application/json; charset=utf-8');
  header('Access-Control-Allow-Origin: *');

  // Output the file content directly (it's already JSON).
  readfile($regioniPath);
?>