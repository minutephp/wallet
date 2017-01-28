/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module Admin {
    export class ProcessorConfigController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');

            $scope.data = {processors: [], tabs: {}};
            $scope.config = $scope.configs[0] || $scope.configs.create().attr('type', 'wallet').attr('data_json', {});
            $scope.settings = $scope.config.attr('data_json');
            $scope.settings.processors = angular.isObject($scope.settings.processors) ? $scope.settings.processors : {};
        }

        save = () => {
            this.$scope.config.save(this.gettext('Processors updated successfully'));
        };
    }

    angular.module('processorConfigApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('processorConfigController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', ProcessorConfigController]);
}
