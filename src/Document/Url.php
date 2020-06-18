<?php


namespace App\Document;

use App\Repository\UrlRepository;
use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Exception;

/**
 * @MongoDB\Document(collection="urls", repositoryClass=UrlRepository::class)
 */
class Url
{
    /**
     * @MongoDB\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $url;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $customer;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $path;

    /**
     * @MongoDB\Field(type="date")
     */
    protected $expireDate;

    /**
     * @MongoDB\Field(type="date")
     */
    protected $lastValidated;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return Url
     */
    public function setUrl($url): Url
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     * @return Url
     */
    public function setCustomer($customer): Url
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     * @return Url
     */
    public function setPath($path): Url
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function getExpireDate()
    {
        if (
            is_null($this->expireDate) ||
            ($this->getLastValidated() < new DateTime("now -1 hour"))
        ) {
            // get new expire date
            $this->setCertificateInfo();
        }

        return $this->expireDate;
    }

    /**
     * @param mixed $expireDate
     * @return Url
     */
    public function setExpireDate($expireDate): Url
    {
        $this->expireDate = $expireDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastValidated()
    {
        return $this->lastValidated;
    }

    /**
     * @param mixed $lastValidated
     * @return Url
     */
    public function setLastValidated($lastValidated): Url
    {
        $this->lastValidated = $lastValidated;
        return $this;
    }

    /**
     * Utility function in case we need this ssl://...:443 url externally
     *
     * @return string
     */
    public function getSslUrl() : string
    {
        return 'ssl://' . $this->url . ':443';
    }

    /**
     * Utility function in case we need this https:// url externally
     *
     * @return string
     */
    public function getHttpsUrl() : string
    {
        return 'https://' . $this->url . '/';
    }

    /**
     * Goes out and gets SSL certificate information and then sets the class properties for
     * @throws Exception
     */
    private function setCertificateInfo() : void
    {
        $stream_context = stream_context_create(
            [
                "ssl" => [
                    "capture_peer_cert" => true,
                    "verify_peer" => false
                ]
            ]
        );

        $error_number = null;
        $error_string = null;
        $fakeExpireDate = new DateTime('April 13, 1969 16:13:00');

        $stream_client = stream_socket_client(
            $this->getSslUrl(),
            $error_number,
            $error_string,
            30,
            STREAM_CLIENT_CONNECT,
            $stream_context
        );
        $stream_context_parameters = stream_context_get_params($stream_client);
        fclose($stream_client);

        $certificate = openssl_x509_parse($stream_context_parameters['options']['ssl']['peer_certificate']);

        try {
            $expireDate = new DateTime('@' . $certificate['validTo_time_t']);

        } catch (Exception $e) {
            $expireDate = $fakeExpireDate;
        }

        $this->setExpireDate($expireDate);
        $this->setLastValidated(new DateTime());
    }

    /**
     * Test whether the certificate expires sooner than $days from now
     *
     * @param int $days
     * @return bool
     */
    public function expiresWithinDays(int $days = 60) : bool
    {
        return ($days > $this->expiresInDays());
    }

    /**
     * Return number of days until certificate expires
     *
     * @return int
     */
    public function expiresInDays() : int
    {
        return (int) (new DateTime())->diff($this->expireDate)->format("%a");
    }

    public static function aSortByDate(array $a, array $b) : int
    {
        /** @var Url $url_a */
        $url_a = $a['url'];
        /** @var Url $url_b */
        $url_b = $b['url'];

        return (self::sortByDate($url_a, $url_b));
    }

    public static function sortByDate(Url $a, Url $b) : int
    {
        if ($a->expireDate === $b->expireDate) {
            return 0;
        }
        return ($a->expireDate < $b->expireDate) ? -1 : 1;
    }


}
