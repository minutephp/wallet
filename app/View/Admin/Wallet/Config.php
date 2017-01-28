<div class="content-wrapper ng-cloak" ng-app="walletConfigApp" ng-controller="walletConfigController as mainCtrl" ng-init="init()">
    <div class="admin-content">
        <section class="content-header">
            <h1>
                <span translate="">Wallet settings</span>
            </h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/admin"><i class="fa fa-dashboard"></i> <span translate="">Admin</span></a></li>
                <li class="active"><i class="fa fa-cog"></i> <span translate="">Wallet settings</span></li>
            </ol>
        </section>

        <section class="content">
            <form class="form-horizontal" name="walletForm" ng-submit="mainCtrl.save()">
                <div class="box box-{{walletForm.$valid && 'success' || 'danger'}}">
                    <div class="box-header with-border">
                        <span translate="">Wallet configuration</span>
                    </div>

                    <div class="box-body">
                        <div class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <span translate="">All users are given a wallet. Every purchase (regardless done via Paypal, Stripe, etc),
                                is first deposited in the user's wallet and then the order is processed using the user's wallet balance.</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><span translate="">Enable deposits:</span></label>
                        <div class="col-sm-9">
                            <label class="radio-inline">
                                <input type="radio" ng-model="settings.wallet.allowDeposits" ng-value="true"> <span translate="">Yes</span>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" ng-model="settings.wallet.allowDeposits" ng-value="false"> <span translate="">No</span>
                            </label>
                            <p class="help-block"><span class="text-sm" translate="">Allow users to make deposits in wallet</span></p>
                        </div>
                    </div>

                    <div class="form-group" ng-show="settings.wallet.allowDeposits">
                        <label class="col-sm-3 control-label"><span translate="">Deposit Url:</span></label>
                        <div class="col-sm-9">
                            <p class="help-block"><span class="fake-link">{{session.site.host}}/wallet/deposit/start?processor=paypal&amount=10</span></p>
                            <p class="help-block"><span translate="" class="text-sm">You can change the amount and processor values as required</span></p>
                        </div>
                    </div>


                    <div class="box-footer with-border">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-flat btn-primary">
                                    <span translate="">Update settings</span>
                                    <i class="fa fa-fw fa-angle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
