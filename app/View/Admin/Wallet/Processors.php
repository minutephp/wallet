<div class="content-wrapper ng-cloak" ng-app="processorConfigApp" ng-controller="processorConfigController as mainCtrl" ng-init="init()">
    <div class="admin-content">
        <section class="content-header">
            <h1>
                <span translate="">Setup payment processors</span>
            </h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/admin"><i class="fa fa-dashboard"></i> <span translate="">Admin</span></a></li>
                <li><a href="" ng-href="/admin/processors"><i class="fa fa-processor"></i> <span translate="">Payment Processors</span></a></li>
            </ol>
        </section>

        <section class="content">
            <minute-event name="import.payment.processors" as="data.processors"></minute-event>

            <form class="form-horizontal" name="processorForm" ng-submit="mainCtrl.save()">
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <i class="fa fa-info"></i> <span translate="">You can find more payment processors on the</span> <a ng-href="/admin/plugins"><span translate="">plugins page</span></a>.
                        </div>

                        <div class="tabs-panel">
                            <ul class="nav nav-tabs">
                                <li ng-class="{active: processor === data.tabs.selectedProcessor}" ng-repeat="processor in data.processors"
                                    ng-init="data.tabs.selectedProcessor = data.tabs.selectedProcessor || processor">
                                    <a href="" ng-click="data.tabs.selectedProcessor = processor">{{processor.name}}</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade in active" ng-repeat="(name, processor) in data.processors" ng-if="processor === data.tabs.selectedProcessor">
                                    <fieldset>
                                        <legend><span translate="">Setup</span> {{processor.name}}</legend>

                                        <div class="form-group" ng-repeat="(key, value) in processor.fields">
                                            <label class="col-sm-3 control-label" for="field"><span translate="">{{value.label || key}}:</span></label>
                                            <div class="col-sm-9">
                                                <input type="{{value.type || 'text'}}" class="form-control" id="field" placeholder="{{value.hint || ('Enter ' + key)}}"
                                                       ng-model="settings.processors[name][key]">
                                                <p class="help-block" ng-show="!!value.hint"><span translate="">{{value.hint}}</span></p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" ng-model="settings.processors[name].enabled"> <span translate="">Enable Processor</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="box-footer with-border">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-primary"><span translate="">Save changes</span> <i class="fa fa-fw fa-angle-right"></i></button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </section>
    </div>
</div>
