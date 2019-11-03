/**
 * 添加 & 编辑
 */
define(['backbone', 'mu/cache', 'mu/common', 'com/dialog'],
    function (Backbone, cache, common, Dialog) {
        var view = Backbone.View.extend({

            initialize: function (options) {
                this._opt = options;
                _.bindAll(this, 'init');
                cache.gets([
                    {src: APP_PATH + '/template/auth/admin_edit.html'},
                    {src: APP_NAME + '/auth_group', type: 'json'}
                ], this.init);
            },

            init: function (results) {
                this._res = results;
                this._tpl = results[0].split('||&&||');
                this._model = this._opt.model;

                this.render();
            },

            tpl: function () {
                var tpls = this._tpl;
                var tpl = {}, arr = [], k, v;
                for (var i = 0; i < tpls.length; i++) {
                    arr = $.trim(tpls[i]).split('|&|');
                    k = arr[0];
                    v = arr[1];
                    tpl[k] = v;
                }
                this._tpl = tpl;
            },

            render: function () {
                this.tpl();

                if (!this._model) {
                    this.edit(null);
                    return this;
                }
                this._model.fetch({
                    success: _.bind(this.edit, this)
                });
            },

            edit: function (model) {

                var data = {};

                if (model) {
                    data = model.toJSON();
                }

                var html = _.template(this._tpl.form)({
                    data: data
                    , group_list: this._res[1].list
                });
                this.$el.html(html);

                this._Dialog = new Dialog({
                    title: '添加',
                    type: 'submit',
                    size: 'wide',
                    model: this._model,
                    html: this.el,
                    onShown: function () {
                        require(['jquery_multi_select'], _.bind(function () {
                            this.$el.find('#groups').multiSelect();
                        }, this));
                    },
                    onHidden: _.bind(this._remove, this)
                });

                this.listenTo(this._Dialog, 'submit', _.bind(this.submit, this));
            },

            submit: function (param) {

                var data = param.data;
                var model = param.model;

                var saveSuccess = _.bind(function (data) {
                    if (data === void 0)
                        return false;
                    this._remove();
                }, this);
                if (data.groups !== void 0) {
                    data.groups = data.groups.join(',');
                }
                if (data.password === '') {
                    delete data.password;
                }
                if (!model) {
                    data.last_ip = '';
                }
                model
                    ? model.save(data, {wait: true, patch: true, success: saveSuccess})
                    : this._opt.view._col.create(data, {wait: true, success: saveSuccess});
            },

            _remove: function () {
                this._Dialog.hide();
                this.remove().off();
            }

        });
        return view;
    }
);