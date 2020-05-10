<?php


namespace App\Services\ExternalServices;


use GuzzleHttp\Client;

class Pushall
{
    /** @var string типы запросов */
    const request_type_self = 'self';
    const request_type_broadcast = 'broadcast';
    const request_type_unicast = 'unicast';
    /**
     * Ключ для API
     * @var string $apiKey
     */
    private $apiKey;

    /**
     * id  учетной записи в сервисе pushall
     * @var string
     */
    private $id;

    protected $url = 'https://pushall.ru/api.php';

    /**
     * Pushall constructor.
     *
     * @param string $apiKey
     * @param string $id
     */
    public function __construct(string $apiKey, string $id)
    {
        $this->apiKey = $apiKey;
        $this->id = $id;
    }

    /**
     * Отправка push уведомления
     *
     * @param string $title
     * @param string $text
     * @return bool|string
     */
    public function send(string $title, string $text)
    {
        $data = [
            'type' => self::request_type_self,
            'id' => $this->id,
            'key' => $this->apiKey,
            'text' => $text,
            'title' => $title,
        ];
        $client = new Client(['base_uri' => $this->url]);
        return $client->post('', ['form_params' => $data]);
    }
}
