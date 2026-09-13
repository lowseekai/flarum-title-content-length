import app from 'flarum/admin/app';

app.initializers.add('litalino/flarum-title-content-length', () => {
  app.registry
    .for('litalino-title-content-length')
    .registerSetting({
      setting: 'litalino-title-length.limit',
      label: app.translator.trans('litalino-title-content-length.admin.settings.limit_title_label'),
      help: app.translator.trans('litalino-title-content-length.admin.settings.limit_title_help'),
      type: 'switch',
    })
    .registerSetting({
      setting: 'litalino-title-length.min',
      label: app.translator.trans('litalino-title-content-length.admin.settings.min_title_label'),
      help: app.translator.trans('litalino-title-content-length.admin.settings.min_title_help'),
      type: 'number',
    })
    .registerSetting({
      setting: 'litalino-title-length.max',
      label: app.translator.trans('litalino-title-content-length.admin.settings.max_title_label'),
      help: app.translator.trans('litalino-title-content-length.admin.settings.max_title_help'),
      type: 'number',
    })
    .registerSetting({
      setting: 'litalino-content-length.limit',
      label: app.translator.trans('litalino-title-content-length.admin.settings.limit_content_label'),
      help: app.translator.trans('litalino-title-content-length.admin.settings.limit_content_help'),
      type: 'switch',
    })
    .registerSetting({
      setting: 'litalino-content-length.min',
      label: app.translator.trans('litalino-title-content-length.admin.settings.min_content_label'),
      help: app.translator.trans('litalino-title-content-length.admin.settings.min_content_help'),
      type: 'number',
    })
    .registerSetting({
      setting: 'litalino-content-length.max',
      label: app.translator.trans('litalino-title-content-length.admin.settings.max_content_label'),
      help: app.translator.trans('litalino-title-content-length.admin.settings.max_content_help'),
      type: 'number',
    })
    .registerPermission(
      {
        icon: 'fas fa-heading',
        label: app.translator.trans('litalino-title-content-length.admin.permissions.bypass_title_label'),
        permission: 'litalino-title-content-length.bypassTitle',
      },
      'moderate'
    )
    .registerPermission(
      {
        icon: 'fas fa-align-left',
        label: app.translator.trans('litalino-title-content-length.admin.permissions.bypass_content_label'),
        permission: 'litalino-title-content-length.bypassContent',
      },
      'moderate'
    );
});
