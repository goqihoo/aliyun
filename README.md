# aliyun

Usage

1. Produce
$authorization = new Authorization($accessKey, $accessSecret);
$producer = new Producer($url, $authorization);
$producer->produce($topic, $producerId, $body);

2. Consume

3. Confirmation

Testing

1. Modify the test data
you need to modify your accessKey and accessSecret provided by aliyun

2. Using phpunit to test
./phpunit
