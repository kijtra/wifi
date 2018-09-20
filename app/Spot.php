<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Spot extends Model
{
    use SpatialTrait;

    protected $spatialFields = [
        'point',
    ];

    protected $lang_avail_values = [];

    public function getNameAttribute()
    {
        return $this->getLangAvailValue('name');
    }

    public function getAddressAttribute()
    {
        return $this->getLangAvailValue('address');
    }

    public function getCategoryAttribute()
    {
        return $this->getLangAvailValue('category');
    }

    public function getAvailLocationAttribute()
    {
        return $this->getLangAvailValue('available_location');
    }

    public function getPrefectureAttribute()
    {
        return $this->getLangAvailValue('prefecture');
    }

    public function getLimitationAttribute()
    {
        return $this->getLangAvailValue('limitation');
    }

    public function getUsageAttribute()
    {
        return $this->getLangAvailValue('usage');
    }

    public function getLatAttribute()
    {
        return $this->point->getLat();
    }

    public function categories()
    {
        return $this->category_en;
    }

    public function getFormatTelAttribute()
    {
        $src = strval($this->tel);
        $src = mb_convert_kana($src, 'asKV');
        $src = trim($src);
        if (empty($src)) {
            return $src;
        } elseif (false !== strpos($src, '-')) {
            return $src;
        }

        $out = preg_replace_callback_array([
            '/\A(0(2|[5-9])0[1-9])(\d{4})(\d{4})/' => function ($m) {
                return $m[1].'-'.$m[3].'-'.$m[4];
            },
            '/\A(0(120|800|990|570))(\d{3})(\d{3})/' => function ($m) {
                return $m[1].'-'.$m[3].'-'.$m[4];
            },
            '/\A0(\d{1})(\d{1})(\d{1})\d+/' => function ($m) {
                if ((1 == $m[1] && 1 == $m[2])
                    || (4 == $m[1] && 2 == $m[2])
                    || (7 == $m[1] && 2 == $m[2])
                    || (8 == $m[1] && 2 == $m[2])
                ) {
                    return preg_replace('/\A(\d{3})(\d{3})(\d{4})/', '$1-$2-$3', $m[0]);
                } elseif ((3 == $m[1])
                    || (6 == $m[1])
                ) {
                    return preg_replace('/\A(\d{2})(\d{4})(\d{4})/', '$1-$2-$3', $m[0]);
                } else {
                    return preg_replace('/\A(\d{4})(\d{2})(\d{4})/', '$1-$2-$3', $m[0]);
                }
            }
        ], $src);

        return $out;
    }

    public function scopeSearchName($query, $term)
    {
        return $query->whereRaw(
            "MATCH (name_ja, name_en, ssid, tel) AGAINST (? IN BOOLEAN MODE)",
            $this->fullTextWildcards($term)
        );
    }

    public function scopeSearchAddress($query, $term)
    {
        return $query->whereRaw(
            "MATCH (address_ja, address_en) AGAINST (? IN BOOLEAN MODE)",
            $this->fullTextWildcards($term)
        );
    }

    public function scopeSearchCategory($query, $term)
    {
        return $query->whereRaw(
            "MATCH (category, available_location, lang) AGAINST (? IN BOOLEAN MODE)",
            $this->fullTextWildcards($term)
        );
    }

    public function scopeLang($query, $term)
    {
        $map = [
            'en' => '英語',
            'tw' => '繁体字',
            'cn' => '簡体字',
            'ko' => '韓国語',
            'th' => 'タイ語',
            'other' => 'その他',
        ];

        $terms = (is_array($term) ? $term : [$term]);
        $query->where(function ($query) use ($map, $terms) {
            foreach ($terms as $lang) {
                if (!empty($map[$lang])) {
                    $query->orWhere('langs', 'like', '%'.$map[$lang].'%');
                }
            }
        });

        return $query;
    }

    public function scopeOfficial($query, $flag = true)
    {
        return $query->where('is_official', '=', (int) $flag);
    }

    protected static function getLang(): string
    {
        static $lang;
        if (null === $lang) {
            $locales = LaravelLocalization::getSupportedLocales();
            $lang = request()->input('lang');
            if (empty($lang) || empty($locales[$lang])) {
                $lang = LaravelLocalization::getCurrentLocale();
            }
        }

        return $lang;
    }

    public function getLangAvailValue($key)
    {
        if (array_key_exists($key, $this->lang_avail_values)) {
            return $this->lang_avail_values[$key];
        }

        if (array_key_exists($key, $this->attributes)) {
            return $this->lang_avail_values[$key] = $this->{$key};
        }

        $lang = static::getLang();
        $request = request()->input('lang');
        if (!empty($this->{$key.'_'.$lang})) {
            $this->lang_avail_values[$key] = $this->{$key.'_'.$lang};
        } elseif ('ja' === $request) {
            // $this->lang_avail_values[$key] = $this->{$key.'_en'};
            $this->lang_avail_values[$key] = null;
        } else {
            // $this->lang_avail_values[$key] = $this->{$key.'_en'};
            $this->lang_avail_values[$key] = $this->{$key.'_en'};
        }

        return $this->lang_avail_values[$key];
    }

    protected function fullTextWildcards($term)
    {
        // removing symbols used by MySQL
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reservedSymbols, '', $term);

        $words = explode(' ', $term);

        foreach ($words as $key => $word) {
            /*
             * applying + operator (required word) only big words
             * because smaller ones are not indexed by mysql
             */
            if (strlen($word) >= 3) {
                $words[$key] = '+' . $word . '*';
            }
        }

        $searchTerm = implode(' ', $words);

        return $searchTerm;
    }
}
