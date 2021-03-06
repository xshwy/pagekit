<?php $view->script('extensions-upload', 'app/system/modules/package/app/upload.js', ['vue-system', 'uikit-upload']) ?>
<?php $view->script('extensions-index', 'app/system/modules/package/app/extensions.js', 'marketplace') ?>

<div id="extensions" class="uk-grid" data-uk-grid-margin>

    <div class="uk-width-medium-1-4">

        <div class="uk-panel uk-panel-divider">
            <ul class="uk-nav uk-nav-side" data-uk-switcher="{connect:'#tab-content', toggle:' > *:not(.uk-nav-header)'}">
                <li class="uk-active"><a href="#">{{ 'Installed' | trans }}</a></li>
                <li>
                    <a href="#">{{ 'Updates' | trans }}
                        <i class="uk-icon-spinner uk-icon-spin" v-show="status == 'loading'"></i>
                        <span class="uk-badge" v-show="updates.length">{{ updates.length }}</span>
                    </a>
                </li>
                <li><a href="#">{{ 'Install' | trans }}</a></li>
                <li class="uk-nav-header">{{ 'Marketplace' | trans }}</li>
                <li><a href="#">{{ 'All' | trans }}</a></li>
            </ul>
        </div>

    </div>
    <div class="uk-width-medium-3-4">

        <ul id="tab-content" class="uk-switcher uk-margin">
            <li>

                <div class="uk-overflow-container">
                    <table class="uk-table uk-table-hover uk-table-middle">
                        <thead>
                            <tr>
                                <th colspan="2">{{ 'Name' | trans }}</th>
                                <th class="pk-table-width-100">{{ 'Version' | trans }}</th>
                                <th class="pk-table-width-minimum uk-text-center">{{ 'Status' | trans }}</th>
                                <th class="pk-table-width-minimum"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-repeat="pkg: packages">
                                <td class="pk-table-width-minimum">
                                    <img class="uk-img-preserve" width="50" height="50" alt="{{ pkg.title }}" v-attr="src: icon(pkg)">
                                </td>
                                <td class="uk-text-nowrap">
                                    <h2 class="uk-h3 uk-margin-remove">{{ pkg.title }}</h2>
                                    <ul class="uk-subnav uk-subnav-line uk-margin-remove">
                                        <li><a>{{ 'Details' | trans }}</a></li>
                                        <li><a>{{ 'Settings' | trans }}</a></li>
                                        <li><a v-attr="href: $url('admin/system/user/permission#ext-:name',{name:pkg.name})">{{ 'Permissions' | trans }}</a></li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="uk-list uk-margin-remove">
                                        <li class="uk-text-truncate">{{ pkg.version }}</li>
                                        <li class="uk-text-truncate">/{{ pkg.name }}</li>
                                    </ul>
                                </td>
                                <td class="uk-text-center">
                                    <a class="uk-button uk-button-success" v-show="pkg.enabled" v-on="click: disable(pkg)">{{ 'Enabled' | trans }}</a>
                                    <a class="uk-button" v-show="!pkg.enabled" v-on="click: enable(pkg)">{{ 'Disabled' | trans }}</a>
                                </td>
                                <td>
                                    <a class="uk-button pk-button-danger" v-show="!pkg.enabled" v-on="click: uninstall(pkg)">{{ 'Delete' | trans }}</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </li>
            <li>

                <div class="uk-overflow-container" v-show="updates">
                    <table class="uk-table uk-table-hover">
                        <thead>
                            <tr>
                                <th colspan="2">{{ 'Name' | trans }}</th>
                                <th class="pk-table-width-minimum"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-repeat="pkg: updates">
                                <td class="pk-table-width-minimum">
                                    <img class="uk-img-preserve" width="50" height="50" alt="{{ pkg.title }}" v-attr="src: pkg.extra.image">
                                </td>
                                <td class="pk-table-min-width-300">
                                    <h2 class="uk-h3 uk-margin-bottom-remove pk-extensions-margin-3 uk-text-nowrap">{{ pkg.title }}</h2>
                                    <ul class="uk-subnav uk-subnav-line uk-margin-remove uk-text-nowrap">
                                        <li><a href="#" data-uk-toggle="{target:'#toggle-'}">{{ 'Changelog' | trans }}</a></li>
                                        <li><span>{{ pkg.version.version }}</span></li>
                                        <li><span>{{ pkg.version.released }}</span></li>
                                    </ul>
                                    <div id="toggle-{{ pkg.name }}" class="uk-hidden uk-margin pk-table-text-break">{{ pkg.version.changelog }}</div>
                                </td>
                                <td>
                                    <button class="uk-button uk-button-primary pk-extensions-margin-5" data-install="{{ pkg.name }}">{{ 'Update' | trans }}</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="uk-alert uk-alert-info uk-margin-remove" v-show="!updates">
                    {{ 'No extension updates found.' | trans }}
                </div>

                <div class="uk-alert uk-alert-warning uk-margin-remove" v-show="status == 'error'">
                    {{ 'An error occurred in retrieving update information. Please try again later.' | trans }}
                </div>

            </li>
            <li>

                <h2 class="pk-form-heading">{{ 'Install an extension' | trans }}</h2>

                <v-upload v-with="action: 'extension'"></v-upload>

            </li>
            <li>

                <form class="uk-form">
                    <input type="text" name="q" placeholder="{{ 'Search' | trans }}" v-model="search">
                </form>

                <hr>

                <v-marketplace v-with="api: api, search: search, installed: packages"></v-marketplace>

            </li>
        </ul>

    </div>

</div>
