<?php

namespace App\Http\Controllers\Backend;

/**
 * App\Http\Controllers\Backend\TranslateController
 * 
 * __DESCRIPTION__
 *
 * @package APPMARKETCMS
 * @category TranslateController
 * @author  Anthony Pillos <dev.anthonypillos@gmail.com>
 * @copyright Copyright (c) 2017
 * @version v1
 */

// use App\Http\Controllers\Controller;

use Barryvdh\TranslationManager\Controller as TMController;
use Barryvdh\TranslationManager\Models\Translation;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class TranslateController extends TMController
{

    public function getIndex($group = null)
    {

        $locales = $this->loadLocales();
        $groups = Translation::groupBy('group');
        $excludedGroups = $this->manager->getConfig('exclude_groups');
        if($excludedGroups){
            $groups->whereNotIn('group', $excludedGroups);
        }

        $groups = array(''=>'Choose a group') + $groups->lists('group', 'group')->toArray();

        $numChanged = Translation::where('group', $group)->where('status', Translation::STATUS_CHANGED)->count();


        $allTranslations = Translation::where('group', $group)->orderBy('key', 'asc')->get();
        $numTranslations = count($allTranslations);
        $translations = array();
        foreach($allTranslations as $translation){
            $translations[$translation->key][$translation->locale] = $translation;
        }
        
        return view('backend.settings.translation.index')
            ->with('translations', $translations)
            ->with('locales', $locales)
            ->with('groups', $groups)
            ->with('group', $group)
            ->with('numTranslations', $numTranslations)
            ->with('numChanged', $numChanged)
            ->with('editUrl', URL::action('Backend\TranslateController@postEdit', array($group)))
            ->with('deleteEnabled', $this->manager->getConfig('delete_enabled'));

        
    }

    protected function loadLocales()
    {


        // //Set the default locale as the first one.
        $locales = array_filter(array_merge(array(config('app.locale')), Translation::groupBy('locale')->lists('locale')->toArray()));
        return array_unique($locales);
    }
}