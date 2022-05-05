@include('crud::fields.inc.wrapper_start')
<div id="{{ $field['name'] }}-dropzone" class="dropzone dropzone-target"></div>
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif
<div id="{{ $field['name'] }}-existing" class="dropzone dropzone-previews">
    @if (isset($field['value']) && count($field['value']))
        @foreach($field['value'] as $key => $file_path)
            <div class="dz-preview dz-image-preview dz-complete text-center">
                <input type="hidden" name="{{ $field['name'] }}[]" value="{{ $file_path }}" />
                <div class="dz-image-no-hover">
                    <img src="{{ config('filesystems.disks.'.$field['disk'].'.url') .'/'. $field['destination_path'] .'/'. $crud->entry->id .'/'. $field['thumb_prefix'] . basename ($file_path) }}" class="img-thumbnail" />
                </div>
                <a class="dz-remove dz-remove-existing" href="javascript:undefined;" data-path="{{ basename ($file_path) }}">
                    {{ trans('releases-crud::releasescrud.remove_file') }}
                </a>
            </div>
        @endforeach
    @endif
</div>
<div id="{{ $field['name'] }}-hidden-input" class="hidden"></div>
<input type="hidden" value="" id="dropzone-files" />
<div id="audioPlayer" class="player-dark">
    <div id="progress-container"><input type="range" class="amplitude-song-slider">
        <progress class="audio-progress audio-progress--played amplitude-song-played-progress"></progress>
        <progress class="audio-progress audio-progress--buffered amplitude-buffered-progress" value="0"></progress>
    </div>
    <div class="audioplayer">
        <div class="song-image"><img data-amplitude-song-info="cover_art_url" height="72" src="/assets/images/cover/cover-1.jpg" alt=""></div>
        <div class="song-info pl-3"><span class="song-name d-inline-block text-truncate" data-amplitude-song-info="name"></span> <span class="song-artists d-block text-muted" data-amplitude-song-info="artist"></span></div>
    </div>
    <div class="audio-controls">
        <div class="audio-controls--left d-flex mr-auto">
            <button type="button" class="btn btn-icon-only amplitude-repeat-song amplitude-repeat-off"><i class="fas fa-sync"></i></button>
        </div>
        <div class="audio-controls--main d-flex">
            <button type="button" class="btn btn-icon-only amplitude-prev"><i class="fas fa-step-backward"></i></button>
            <button type="button" class="btn btn-air btn-pill btn-default btn-icon-only amplitude-play-pause"><i class="fas fa-play"></i> <i class="fas fa-pause"></i></button>
            <button type="button" class="btn btn-icon-only amplitude-next"><i class="fas fa-step-forward"></i></button>
        </div>
        <div class="audio-controls--right d-flex ml-auto">
            <button type="button" class="btn btn-icon-only amplitude-shuffle amplitude-shuffle-off"><i class="fas fa-random"></i></button>
        </div>
    </div>
    <div class="audio-info d-flex align-items-center pr-4"><span class="mr-4"><span class="amplitude-current-minutes"></span>:<span class="amplitude-current-seconds"></span> / <span class="amplitude-duration-minutes"></span>:<span class="amplitude-duration-seconds"></span></span>
        <div class="audio-volume dropup">
            <button type="button" class="btn btn-icon-only dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-volume-down"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right volume-dropdown-menu"><input type="range" class="amplitude-volume-slider" value="100"></div>
        </div>
        <button type="button" class="btn btn-icon-only" id="playList"><i class="fas fa-music"></i></button>
    </div>
</div>
<aside id="rightSidebar">
    <div class="right-sidebar-header">Плейлист</div>
    <div class="right-sidebar-body" data-scrollable="true">
        <ul class="list-group list-group-flush"></ul>
    </div>
</aside>
@include('crud::fields.inc.wrapper_end')


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
        <style>
            .dropzone-target {
                background: #f3f3f3;
                border: 2px dashed #ddd;
                border-bottom-left-radius: 10px;
                border-bottom-right-radius: 10px;
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;
                color: #999;
                font-size: 1.2em;
                padding: 2em;
            }
            .dropzone-previews {
                margin-top: 5px;
                padding: 0;
                border: 0;
                margin-left: -5px;
                margin-right: 5px;
            }
            .dropzone.dz-drag-hover {
                background: #ececec;
                border-bottom: 2px dashed #999;
                border-left: 2px dashed #999;
                border-right: 2px dashed #999;
                color: #333;
            }
            .dz-message {
                text-align: center;
            }
            .dropzone .dz-preview {
                position: relative;
                display: inline-block;
                vertical-align: top;
                margin: 4px;
                min-height: 100px;
                width: 100%;
                background: #f3f3f3;
                border: 2px dashed #ddd;
                border-bottom-left-radius: 10px;
                border-bottom-right-radius: 10px;
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;
                color: #999;
            }
            .dropzone .dz-preview .dz-image-no-hover {
                cursor: move;
                display: block;
                overflow: hidden;
                position: relative;
                z-index: 10;
            }

            .dropzone .dz-preview .dz-progress {
                opacity: 1;
                z-index: 1000;
                pointer-events: none;
                position: absolute;
                height: 5px;
                left: 40px;
                top: 50%;
                margin-top: 0px;
                width: 100%;
                /* margin-left: -40px; */
                background: #ffffff;
                -webkit-transform: scale(1);
                border-radius: 0;
                overflow: hidden;
            }

            .dropzone .dz-preview .dz-progress .dz-upload {
                background: #41a285;
                /* background: linear-gradient(to bottom,#666,#444); */
                position: absolute;
                top: 0;
                left: 0;
                bottom: 0;
                width: 0;
                -webkit-transition: width .3s ease-in-out;
                -moz-transition: width .3s ease-in-out;
                -ms-transition: width .3s ease-in-out;
                -o-transition: width .3s ease-in-out;
                transition: width .3s ease-in-out;
            }

            /* Audioplayer */

            #audioPlayer {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
                position: fixed;
                right: 0px;
                bottom: 0px;
                left: 0px;
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                background-color: #fff;
                border-radius: 0;
                height: 4.5rem;
                /*z-index: 1004;*/
                z-index: 999;
                -webkit-box-shadow: 0 1px 12px 2px rgb(0 0 0 / 15%);
                box-shadow: 0 1px 12px 2px rgb(0 0 0 / 15%);
                -webkit-transition: .4s all ease-in;
                -o-transition: .4s all ease-in;
                transition: .4s all ease-in;
            }
            progress::-moz-progress-bar { background: #ea1730 !important; }
            progress::-webkit-progress-value { background: #ea1730 !important; }
            progress { color: #ea1730 !important; }
            /*
            #ea1730
            */
            #progress-container {
                position: absolute;
                top: 0;
                /*right: .625rem;
                left: .625rem;*/
                right: 0;
                left: 0;
            }
            #progress-container input[type=range] {
                position: absolute;
                top: 0;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                width: 100%;
                background-color: transparent;
                /*height: .125rem;*/
                height: 3px;
                z-index: 3;
                cursor: pointer;
            }
            #progress-container .audio-progress {
                position: absolute;
                top: 0;
                left: 0;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                display: block;
                /*height: .125rem;
                border-radius: .125rem;*/
                height: 3px;
                background: 0 0;
                border: none;
                width: 100%;
            }
            /*#audioPlayer:hover .audio-progress {
                height: .25rem;
            }*/
            #progress-container .audio-progress.audio-progress--buffered {
                z-index: 1;
            }
            #progress-container .audio-progress.audio-progress--played {
                z-index: 2;
            }
            progress {
                vertical-align: baseline;
            }

            .audioplayer {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
                -webkit-box-flex: 0;
                -ms-flex: 0 0 37%;
                flex: 0 0 37%;
                max-width: 37%;
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
            }
            .audioplayer .song-image {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 4.5rem;
                flex: 0 0 4.5rem;
                max-width: 4.5rem;
            }
            .audioplayer .song-image img {
                /*border-top-left-radius: 1rem;
                border-bottom-left-radius: 1rem;*/
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }
            .audioplayer .song-info {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 calc(100% - 4.5rem);
                flex: 0 0 calc(100% - 4.5rem);
                max-width: calc(100% - 4.5rem);
                padding-left: .5rem;
            }
            .audioplayer .song-name {
                font-weight: 600;
                text-transform: capitalize;
            }
            .audioplayer .song-artists, .audio .song-name {
                max-width: 100%;
            }
            .text-muted {
                color: #3f454a!important;
            }

            .audio-controls {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                justify-content: center;
                -webkit-box-flex: 0;
                -ms-flex: 0 0 26%;
                flex: 0 0 26%;
                max-width: 26%;
                align-items: center;
            }
            .mr-auto, .mx-auto {
                margin-right: auto!important;
            }
            .btn-icon-only [class*=" ion-"],
            .btn-icon-only [class*=" la-"],
            .btn-icon-only [class^=ion-],
            .btn-icon-only [class^=la-] {
                width: 1.25rem;
                height: 1.25rem;
                font-size: 1.25rem;
                line-height: 1;
            }
            .audio-controls--left .btn,
            .audio-controls--right .btn {
                color: #6c757d;
            }
            .btn-icon-only.active > *,
            .amplitude-shuffle-on > *,
            .amplitude-repeat-on > *,
            .amplitude-repeat-song-on > *,
            .amplitude-play-pause:hover > * {
                color: #ea1730;
                transition: color .3s ease-in-out;
            }
            .amplitude-playing > .fa-play,
            .amplitude-paused > .fa-pause  {
                display: none;
            }
            .ion-md-sync:before {
                content: "\f38b";
            }
            .ion-md-play:before {
                content: "\f357";
            }
            .ion-md-skip-backward:before {
                content: "\f37c";
            }
            .ion-md-skip-forward:before {
                content: "\f37d";
            }
            .ion-md-shuffle:before {
                content: "\f37b";
            }
            .ion-md-volume-low:before {
                content: "\f131";
            }
            .la-ellipsis-v:before {
                content: "\f1c4";
            }
            .ion-md-musical-note:before {
                content: "\f332";
            }
            .fa-ellipsis-h:before {
                content: "\f141";
            }

            .la-heart-o:before {
                content: "\f234";
            }
            .la-plus:before {
                content: "\f2c2";
            }
            .la-download:before {
                content: "\f1bd";
            }
            .la-share-alt:before {
                content: "\f2f1";
            }
            .la-info-circle:before {
                content: "\f24b";
            }
            .d-flex {
                display: -webkit-box!important;
                display: -ms-flexbox!important;
                display: flex!important;
            }
            /*.btn {
                display: inline-block;
                font-weight: 400;
                color: #222629;
                text-align: center;
                vertical-align: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                background-color: transparent;
                border: 1px solid transparent;
                padding: .625rem 1.5rem;
                font-size: .875rem;
                line-height: 1;
                /*border-radius: .25rem;*/
            -webkit-transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
            -o-transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
            }*/
            .btn-icon-only {
                padding: 0 !important;
                width: 2.5rem;
                height: 2.5rem;
            }
            .btn-default.btn-air {
                -webkit-box-shadow: 0 2px 6px 2px rgb(34 38 41 / 15%);
                box-shadow: 0 2px 6px 2px rgb(34 38 41 / 15%);
            }
            .audio-controls--main .btn-default {
                margin-right: .5rem;
                margin-left: .5rem;
            }
            .amplitude-play-pause .ion-md-pause {
                display: none;
            }
            .ml-auto, .mx-auto {
                margin-left: auto!important;
            }
            .audio-controls--left .btn,
            .audio-controls--right .btn {
                color: #6c757d;
            }

            .audio-info {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 37%;
                flex: 0 0 37%;
                max-width: 37%;
                -webkit-box-pack: end;
                -ms-flex-pack: end;
                justify-content: flex-end;
            }
            .audio-volume .dropdown-menu {
                padding-left: 1rem;
                padding-right: 1rem;
                /*padding-bottom: 0;*/
            }

            .dropdown-menu {
                -webkit-box-shadow: 0 1px 12px 2px rgb(0 0 0 / 15%);
                box-shadow: 0 1px 12px 2px rgb(0 0 0 / 15%);
            }
            .dropdown-menu-right {
                right: 0;
                left: auto;
            }
            .dropdown-menu {
                position: absolute;
                top: 100%;
                left: 0;
                z-index: 1000;
                display: none;
                float: left;
                min-width: 10rem;
                padding: .5rem 0;
                margin: .125rem 0 0;
                font-size: .875rem;
                color: #222629;
                text-align: left;
                list-style: none;
                background-color: #fff;
                background-clip: padding-box;
                border: 0 solid rgba(0,0,0,.15);
                border-radius: 0rem;
            }


            .audio-volume input[type=range] {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                position: relative;
                /*top: -.25rem;*/
                width: 100%;
                cursor: pointer;
                height: 3px;
                border: none;
                box-shadow: none;
                outline: none;
                top: -.24rem;
            }
            .audio-volume input[type='range']::-webkit-slider-runnable-track {
                height: 3px;
                -webkit-appearance: none;
                color: #13bba4;
                /*margin-top: -4px;*/
                background-color: #808080;
            }
            .audio-volume input[type='range']::-webkit-slider-thumb {
                margin-top: -6px;
            }

            .audio-volume .dropup .dropdown-toggle:after,
            .audio-volume .dropdown-toggle:after {
                border-bottom: 0.3em solid;
                border-left: 0.3em solid transparent;
                border-right: 0.3em solid transparent;
                border-top: 0;
                content: none;
                display: inline-block;
                margin-left: 0.255em;
                vertical-align: 0.255em;
            }
            /*
            .audio-volume input[type='range'] {
                overflow: hidden;
                width: 80px;
                -webkit-appearance: none;
                background-color: #9a905d;
            }
            .audio-volume input[type='range']::-webkit-slider-runnable-track {
                height: 10px;
                -webkit-appearance: none;
                color: #13bba4;
                margin-top: -1px;
            }
            .audio-volume input[type='range']::-webkit-slider-thumb {
                width: 10px;
                -webkit-appearance: none;
                height: 10px;
                cursor: ew-resize;
                background: #434343;
                box-shadow: -80px 0 0 80px #43e5f7;
            }
            */

            .dropdown, .dropleft, .dropright, .dropup {
                position: relative;
            }
            .dropdown-item {
                display: table;
                width: 100%;
            }
            .dropdown-item {
                display: block;
                width: 100%;
                padding: .5rem 1.5rem;
                clear: both;
                font-weight: 400;
                color: #222629;
                text-align: inherit;
                white-space: nowrap;
                background-color: transparent;
                border: 0;
            }

            .dropdown-item a {
                text-decoration: none;
                font-size: 18px;
                font-weight: 600;
                color: #000;
            }

            .dropdown-item a i {
                width: 24px;
                height: 24px;
                text-align: center;
                margin-right: 8px;
            }


            .ps {
                position: relative;
            }
            .mr-4, .mx-4 {
                margin-right: 1.5rem!important;
            }
            .pr-4, .px-4 {
                padding-right: 1.5rem!important;
            }
            .align-items-center {
                -webkit-box-align: center!important;
                -ms-flex-align: center!important;
                align-items: center!important;
            }
            .d-flex {
                display: -webkit-box!important;
                display: -ms-flexbox!important;
                display: flex!important;
            }
            .ml-auto, .mx-auto {
                margin-left: auto!important;
            }
            .text-truncate {
                overflow: hidden;
                -o-text-overflow: ellipsis;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .mb-0, .my-0 {
                margin-bottom: 0!important;
            }
            .font-sm {
                font-size: .75rem !important;
            }


            #rightSidebar {
                position: fixed;
                top: 150px;
                right: -22rem;
                bottom: 132px;
                width: 22rem;
                background-color: #fff;
                /*border-bottom-left-radius: 1rem;
                border-top-left-radius: 1rem;*/
                z-index: 1004;
                -webkit-box-shadow: 0 1px 10px 2px rgb(0 0 0 / 15%);
                box-shadow: 0 1px 10px 2px rgb(0 0 0 / 15%);
                -webkit-transition: .4s all ease-in;
                -o-transition: .4s all ease-in;
                transition: .4s all ease-in;
            }
            .open-right-sidebar #rightSidebar {
                right: 30px;
            }
            #rightSidebar .right-sidebar-header {
                /*border-top-left-radius: 1rem;*/
                padding: 1rem 1.5rem;
                background-color: #7c69ef;
                font-weight: 600;
                color: #fff;
                text-transform: uppercase;
            }
            #rightSidebar .right-sidebar-body {
                /*border-bottom-left-radius: 1rem;*/
                /*height: calc(100% - 3.25rem);*/
                height: calc(100% - 59px);
                overflow: auto;
            }
            .list-group {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
                padding-left: 0;
                margin-bottom: 0;
            }
            .list-group-flush:first-child .list-group-item:hover {
                background: #ddd
            }
            .list-group-flush:first-child .list-group-item:first-child {
                border-top: 1px solid rgba(0,0,0,.125);
            }
            .list-group-flush:first-child .list-group-item:first-child {
                border-top: 0;
            }

            .list-group-flush .list-group-item {
                border-right: 1px solid rgba(0, 0, 0, 0);
                border-left: 1px solid rgba(0, 0, 0, 0);
                border-radius: 0;
            }
            .list-group-flush .list-group-item {
                border-right: 0;
                border-left: 0;
                border-radius: 0;
                display: flex;
            }
            .list-group-item:first-child {
                border-top-left-radius: 0rem;
                border-top-right-radius: 0rem;
            }
            .list-group-item {
                margin-bottom: -1px;
            }
            .custom-list--item {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                padding: 5px;
            }
            .list-group-item {
                position: relative;
                display: block;
                padding: .75rem 1.25rem;
                margin-bottom: -1px;
                background-color: #fff;
                border: 1px solid rgba(0,0,0,.125);
            }
            .custom-list--item .custom-card--inline {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 78%;
                flex: 0 0 78%;
                max-width: 78%;
                padding-right: .5rem;
            }
            .custom-card--inline {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                width: 100%;
                cursor: pointer;
            }
            .custom-card--inline .custom-card--inline-img {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 2.5rem;
                flex: 0 0 2.5rem;
                max-width: 2.5rem;
                margin-top: -13px;
                position: relative;
            }
            .custom-card--inline .custom-card--inline-img img {
                max-width: 100%;
            }
            .custom-card--inline .custom-card--inline-desc {
                padding-left: 1rem;
                -webkit-box-flex: 0;
                -ms-flex: 0 0 calc(100% - 2.5rem);
                flex: 0 0 calc(100% - 2.5rem);
                max-width: calc(100% - 2.5rem);
            }
            .custom-card--inline .custom-card--inline-desc * {
                font-weight: 600;
            }
            .custom-card--labels {
                margin: 0;
                padding: 0;
                list-style: none;
                flex: 0 0 22%;
                max-width: 22%;
                justify-content: flex-end;
            }

            .pattern-black .logo {
                padding: 0;
            }


            @media (max-width: 1023px) {
                #audioPlayer {
                    right: 10px;
                    bottom: 10px;
                    left: 10px;
                }

                #rightSidebar {
                    bottom: 92px;
                    top: 80px;
                }

                .open-right-sidebar #rightSidebar {
                    right: 10px;
                }

                .textAnimate svg {
                    width: 100%;
                    height: 80px;
                    margin-top: -5%;
                }

                .textAnimate .a.gradientButton {
                    margin: .5em auto;
                    padding: .3em 1.5em;
                }

                .ps-content p {
                    display: block;
                }
                .js .ps-content p {
                    padding: 5px 25px 5px 10px;
                    height: 125px;
                    margin-right: 125px;
                    color: #000;
                }
                .ps-content a {
                    display: initial;
                }
                .ps-content h3 {
                    /*display: table-row;*/
                    display: block;
                    height: auto;
                    padding-right: 125px;
                    padding-left: 10px;
                }
                .ps-contentwrapper > nav {
                    top: 0;
                    left: inherit;
                    margin-left: 0;
                    position: absolute;
                    right: 20px;
                }
            }

            @media (max-width: 1200px) {
                .audio-info {
                    display: none !important;
                }
                .audioplayer {
                    -webkit-box-flex: 0;
                    -ms-flex: 0 0 55%;
                    flex: 0 0 55%;
                    max-width: 55%;
                }
                .audio-controls {
                    -webkit-box-flex: 0;
                    -ms-flex: 0 0 45%;
                    flex: 0 0 45%;
                    max-width: 45%;
                    padding-right: 1.5rem;
                }
                .footer {
                    padding-bottom: 100px;
                }
            }

            @media (max-width: 576px) {
                .audioplayer {
                    -webkit-box-flex: 0;
                    -ms-flex: 0 0 4.5rem;
                    flex: 0 0 4.5rem;
                    max-width: 4.5rem;
                }
                /*
                .ps-container,
                .ps-slides {
                    min-height: 800px;
                }
                */
                .ps-content p {
                    color: #080808;
                }
            }

            @media (max-width: 479px) {
                .hs-wrapper .hs-links {
                    transform: translateY(0);
                }
                .xHoverLink a {
                    top: 0;
                }
                .song-info {
                    display: none;
                }
                .audio-controls {
                    -webkit-box-flex: 0;
                    -ms-flex: 0 0 calc(100% - 4.5rem);
                    flex: 0 0 calc(100% - 4.5rem);
                    max-width: calc(100% - 4.5rem);
                    padding-left: 1.5rem;
                }
                .ps-content {
                    display: block;
                    padding-top: 25px;
                }
                /*.ps-contentwrapper>.ps-content:last-child {
                    position: relative;
                }*/
            }
        </style>
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.js" integrity="sha512-llCHNP2CQS+o3EUK2QFehPlOngm8Oa7vkvdUpEFN71dVOf3yAj9yMoPdS5aYRTy8AEdVtqUBIsVThzUSggT0LQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.13.0/Sortable.min.js" integrity="sha512-5x7t0fTAVo9dpfbp3WtE2N6bfipUwk7siViWncdDoSz2KwOqVC1N9fDxEOzk0vTThOua/mglfF8NO7uVDLRC8Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/amplitudejs@5.3.2/dist/amplitude.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>
        <script>
            var track = '';

            "use strict";

            //=> Class Definition
            var AudioPlayer = AudioPlayer || {};

            Dropzone.autoDiscover = false;
            $("div#{{ $field['name'] }}-dropzone").dropzone({
                params: {
                    disk            : "{{ $field['disk'] }}",
                    destination_path: "{{ $field['destination_path'] }}"
                },
                url: "{{ URL::current().'/track/add' }}",
                acceptedFiles: "audio/mp3, audio/mpeg",
                maxFilesize: {{ $field['max_file_size'] ?? 25 }},
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}'
                },
                dictDefaultMessage: "{{ trans('songs-crud::songscrud.drop_to_upload') }}",
                dictFallbackMessage: "{{ trans('songs-crud::songscrud.not_supported') }}",
                dictFallbackText: null,
                dictInvalidFileType: "{{ trans('songs-crud::songscrud.invalid_file_type') }}",
                dictFileTooBig: "{{ trans('songs-crud::songscrud.file_too_big') }}",
                dictResponseError: "{{ trans('songs-crud::songscrud.response_error') }}",
                dictMaxFilesExceeded: "{{ trans('songs-crud::songscrud.max_files_exceeded') }}",
                dictCancelUpload: "{{ trans('songs-crud::songscrud.cancel_upload') }}",
                dictCancelUploadConfirmation: "{{ trans('songs-crud::songscrud.cancel_upload_confirmation') }}",
                dictRemoveFile: "{{ trans('songs-crud::songscrud.remove_file') }}",
                success: function (file, response, request) {
                    if (response.success) {
                        $(file.previewElement).find('.dropzone-filename-field').val(response.filename);
                    }
                },
                addRemoveLinks: true,
                removedFile: function(file, response) {
                    let name = response.filename;

                    $.ajax({
                        type: 'POST',
                        url: '{{ URL::current().'/track/remove' }}',
                        data: {name: name},
                        success: function(data){
                            console.log('success: ' + data);
                        }
                    });
                    let _ref;
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                },
                init: function() {
                    this.on("success", function(file, response) {
                        $(function () {
                            AudioPlayer = {
                                //=> Initialize function to call all functions of the class
                                init: function () {
                                    if ($('#audioPlayer').length === 0) {
                                        return false;
                                    }
                                    AudioPlayer.initAudioPlayer();
                                    AudioPlayer.volumeDropdownClick();
                                    AudioPlayer.volumeIconClick();
                                    AudioPlayer.addAudioInPlayer();
                                },

                                //=> Initialize audio player
                                initAudioPlayer: function () {
                                    let songs = [];
                                    $.get("/admin/songs/releases/json", function(data) {
                                        data.forEach(function (d, i) {
                                            console.log(d.name);
                                            let song = {
                                                name: d.name,
                                                artist: d.artist,
                                                album: d.album,
                                                url: d.url,
                                                cover_art_url: d.image
                                            };
                                            let playlist = '<li class="custom-list--item list-group-item"><div class="text-dark custom-card--inline amplitude-song-container amplitude-play-pause" data-amplitude-song-index="' + i + '" data-amplitude-playlist="special"><div class="custom-card--inline-img"><img src="' + d.image + '" alt="' + d.artist + ' - ' + d.name + '" class="card-img--radius-sm"></div><div class="custom-card--inline-desc"><p class="text-truncate mb-0">' + d.name + '</p><p class="text-truncate text-muted font-sm">' + d.artist + '</p></div></div><ul class="custom-card--labels d-flex ml-auto"><li class="dropleft"><button type="button" class="btn btn-air btn-pill btn-default btn-icon-only amplitude-play-pause" data-amplitude-song-index="' + i + '" data-amplitude-playlist="special"><i class="fas fa-play"></i> <i class="fas fa-pause"></i></button></li></ul></li>';
                                            $(".list-group.list-group-flush").append(playlist);
                                            songs.push(song);
                                        });
                                        Amplitude.init({
                                            "songs": songs,
                                            "playlists": {
                                                "special": {
                                                    songs: songs
                                                }
                                            }
                                        });
                                    });
                                },

                                //=> Volume dropdown click
                                volumeDropdownClick: function () {
                                    $(document).on('click', '.volume-dropdown-menu', function (e) {
                                        e.stopPropagation();
                                    });
                                },

                                //=> Change volume icon in audio player from it's range
                                volumeIconClick: function () {
                                    var $audioInput = $('.audio-volume input[type="range"]');
                                    var $audioButton = $('.audio-volume .btn');

                                    $audioInput.on('change', function () {
                                        var $this = $(this);
                                        var value = parseInt($this.val(), 10);

                                        if (value === 0) {
                                            $audioButton.html('<i class="fas fa-volume-mute"></i>');
                                        } else if (value > 0 && value < 70) {
                                            $audioButton.html('<i class="fas fa-volume-down"></i>');
                                        } else if (value > 70) {
                                            $audioButton.html('<i class="fas fa-volume-up"></i>');
                                        }
                                    })
                                },

                                //=> Add audio in player on click of card
                                addAudioInPlayer: function () {
                                    var $audio = $('a[data-audio]');

                                    $audio.on('click', function () {
                                        var audioData = $(this).data('audio');
                                        Amplitude.removeSong(0);
                                        Amplitude.playNow(audioData);
                                    })
                                }
                            };
                            //=> Call class at document ready
                            $(document).ready(AudioPlayer.init);
                        });
                    })
                },
                previewsContainer: "div#{{ $field['name'] }}-existing",
                hiddenInputContainer: "div#{{ $field['name'] }}-hidden-input",
                uploadMultiple: false,
                autoDiscover: false,
                createImageThumbnails: false,
                previewTemplate: '<div class="dz-preview dz-file-preview"><span data-dz-name></span> <strong class="dz-size" data-dz-size></strong><input type="hidden" name="{{ $field["name"] }}[]" class="dropzone-filename-field" /><div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div><div class="dz-error-message"><span data-dz-errormessage></span></div><div class="dz-success-mark"><svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"><title>Check</title><defs></defs><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"><path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path></g></svg></div><div class="dz-error-mark"><svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"><title>Error</title><defs></defs><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"><g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475"><path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path></g></g></svg></div></div>'
            });

            let el = document.getElementById('{{ $field['name'] }}-existing');

            let sortable = new Sortable(el, {
                group: "{{ $field['name'] }}-sortable",
                handle: ".dz-preview",
                draggable: ".dz-preview",
                scroll: false,
                dataIdAttr: 'data-id',
            });

            $("#playList").on("click", function () {
                $("body").toggleClass("open-right-sidebar");
                $(this).toggleClass("active");
            });
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
