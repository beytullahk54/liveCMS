<?php

namespace App\liveCMS\Models;

use App\liveCMS\Models\Contracts\BaseModelInterface as BaseModelContract;
use App\liveCMS\Models\Traits\BaseModelTrait;
use App\liveCMS\Models\Traits\ModelAuthorizationTrait;

class SiteModel extends Site implements BaseModelContract
{
    use BaseModelTrait, ModelAuthorizationTrait;

    protected $table= 'sites';

    // protected $dependencies = ['postable.children'];

    // protected $appends = ['type'];

    public function rules()
    {
        $uri = explode('/', request()->get('permalink'));
        $uri = array_splice($uri, 0, 5);
        $permalink = implode('/', array_map('str_slug', $uri));

        request()->merge(compact('permalink'));

        return [
            'permalink' => 'required|unique:'.$this->getTable().',permalink'.(($this->id != null) ? ','.$this->id : ''),
        ];
    }

    public function newQuery()
    {
        $this->firstAuthorization();

        return parent::newQuery();
    }
}
