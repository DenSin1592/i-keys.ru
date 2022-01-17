<?php

namespace App\Services\Helper;

use App\Models\Product;
use Illuminate\Mail\Message;

class Helper
{
    /**
     * Get array of valid emails
     *
     * @param string $emails
     * @param string|null $default
     * @return array
     */
    public function getValidEmails(string $emails, string $default = null): array
    {
        $validate = function (string $email) {
            return \Validator::make(['email' => $email], ['email' => ['required', 'email']])->passes();
        };

        $validEmails = [];
        foreach (explode(',', $emails) as $email) {
            $email = trim($email);
            if ($validate($email)) {
                $validEmails[] = $email;
            }
        }

        if (count($validEmails) == 0 && isset($default) && $validate($default)) {
            $validEmails[] = $default;
        }

        return $validEmails;
    }

    /**
     * Set replyTo mail header
     *
     * @param \Illuminate\Mail\Message $message
     * @param string|null $email
     * @param string|null $name
     */
    public function setReplyToHeader(Message $message, string $email = null, string $name = null): void
    {
        if (\Validator::make(['email' => $email], ['email' => ['required', 'email']])->passes()) {
            $message->replyTo($email, $name);
        }
    }

    /**
     * Phone to tel: \d+ convert
     *
     * @param string $string
     * @return string
     */
    private function telFormat(string $string): string
    {
        return str_replace(' ', '', strtr(strip_tags($string), '()-', '   '));
    }


    /**
     * Get tel link
     *
     * @param string $string
     * @return string
     */
    public function telLink(string $string): string
    {
        return 'tel:' . $this->telFormat($string);
    }

    /**
     * Get whatsApp link
     *
     * @param string $string
     * @return string
     */
    public function whatsappLink(string $string): string
    {
        $phone = str_replace('+', '', $this->telFormat($string));

        return "https://msng.link/o/?{$phone}=wa";
    }


    /**
     * Get mailto link
     *
     * @param string $email
     * @return string
     */
    public function mailtoLink(string $email): string
    {
        return 'mailto:' . $email;
    }

    /**
     * Out date format.
     *
     * @param \Carbon\Carbon $datetime
     * @return string
     */
    public function outDatetime(\Carbon\Carbon $datetime): string
    {
        return $datetime->format('d.m.Y H:i:s');
    }

    /**
     * Return url with query string.
     *
     * @param $url
     * @param array $queryData
     * @param bool $removeEmpty
     * @return string
     */
    public function urlWithHttpQuery(string $url, array $queryData = [], bool $removeEmpty = true): string
    {
        if ($removeEmpty) {
            $queryData = array_filter(
                $queryData,
                function ($e) {
                    return $e !== '';
                }
            );
        }

        $query = http_build_query($queryData);
        if (!empty($query)) {
            $url .= '?' . $query;
        }

        return $url;
    }

    /**
     * Return url with for products view.
     *
     * @param $url
     * @param $productsView
     * @return string
     */
    public function urlWithProductsView(string $url, $productsView): string
    {
        $parsedUrl = parse_url($url);
        $parsedQuery = \Arr::get($parsedUrl, 'query');
        if (!is_string($parsedQuery)) {
            $parsedQuery = '';
        }

        parse_str($parsedQuery, $queryData);
        $productsView = $this->prepareProductsView($productsView);
        if (!empty($productsView)) {
            $queryData['view'] = $productsView;
        } else {
            unset($queryData['view']);
        }

        $newQuery = http_build_query($queryData);
        if (!empty($newQuery)) {
            $parsedUrl['query'] = $newQuery;
        } else {
            unset($parsedUrl['query']);
        }

        return $this->unparseUrl($parsedUrl);
    }

    /**
     * Unparse a URL components
     *
     * @param array $parsed_url
     * @return string
     */
    function unparseUrl(array $parsed_url): string
    {
        $scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
        $host = isset($parsed_url['host']) ? $parsed_url['host'] : '';
        $port = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
        $user = isset($parsed_url['user']) ? $parsed_url['user'] : '';
        $pass = isset($parsed_url['pass']) ? ':' . $parsed_url['pass'] : '';
        $pass = ($user || $pass) ? "$pass@" : '';
        $path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        $query = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
        $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';

        return "$scheme$user$pass$host$port$path$query$fragment";
    }

    /**
     * Price format.
     *
     * @param $price
     * @param $allowEmpty
     * @param $withMeasure
     * @return string
     */
    function priceFormat($price, $allowEmpty = false, $withMeasure = false)
    {
        $formatPrice = '';

        $price = floatval($price);

        if (!empty($price) || $allowEmpty) {
            $formatPrice = number_format(ceil($price), 0, '.', ' ');
            if ($withMeasure) {
                $formatPrice .= ' ' . $this->priceMeasure();
            }
        }

        return $formatPrice;
    }

    public function priceMeasure()
    {
        return '<span class="rouble" >руб.</span>';
    }

    public function prepareProductsView($productsView)
    {
        if ($productsView !== Product::VIEW_LIST) {
            $productsView = '';
        }

        return $productsView;
    }

    /**
     * Get max upload file size.
     *
     * @param string $format - format of result: b      - bytes, by default;
     *                                           k (kb) - kilobytes;
     *                                           m (mb) - megabytes;
     *                                           g (gb) - gigabytes.
     *
     * @return int size
     */
    public function maxUploadFileSize($format = 'b'): int
    {
        /**
         * Converts shorthands like "2M" or "512K" to bytes.
         *
         * @param $size
         *
         * @return int
         */
        $normalize = function ($size) {
            if (preg_match('/^([\d\.]+)([KMG])$/i', $size, $match)) {
                $pos = array_search($match[2], array("K", "M", "G"));
                if ($pos !== false) {
                    $size = $match[1] * pow(1024, $pos + 1);
                }
            }

            return $size;
        };
        $maxUpload = $normalize(ini_get('upload_max_filesize'));
        $maxPost = $normalize(ini_get('post_max_size'));
        $memoryLimit = $normalize(ini_get('memory_limit'));

        $min = min($maxUpload, $maxPost, $memoryLimit);

        switch (\Str::lower($format)) {
            case 'b':
                return $min;
            case 'k':
            case 'kb':
                return $min / 1024;
            case 'm':
            case 'mb':
                return $min / (1024 * 1024);
            case 'g':
            case 'gb':
                return $min / (1024 * 1024 * 1024);
            default:
                return $min;

        }
    }

    /**
     * Does the array elements are all the same?
     *
     * @param array $array
     * @return bool
     */
    public function arrayHasAllSame(array $array)
    {
        return count(array_map('unserialize', array_unique(array_map('serialize', $array)))) == 1;
    }

    /**
     * Replace squire brackets in source string by something.
     *
     * @param string $subject
     * @param string $replace
     * @return string
     */
    public function replaceSquareBrackets(string $subject, string $replace): string
    {
        return trim(str_replace(['[', ']'], $replace, str_replace('][', $replace, $subject)), $replace);
    }
}
