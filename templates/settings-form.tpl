<script type="text/javascript">
	$(function() {ldelim}
		// Attach the form handler.
		$('#opensciencebadges-settings-form').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});
</script>

<form
  class="pkp_form"
  id="opensciencebadges-settings-form"
  method="post" action="{url router=$smarty.const.ROUTE_COMPONENT op="manage" category="generic" plugin=$pluginName verb="save"}"
>
	{csrf}

	{include file="controllers/notification/inPlaceNotification.tpl" notificationId="usageStatsSettingsFormNotification"}

	{fbvFormArea id="opensciencebadges-settings-form-area"}
		{fbvFormSection
      for="size"
      id="opensciencebadges-size-section"
      label="plugins.generic.openScienceBadges.settings.size"
      description="plugins.generic.openScienceBadges.settings.size.desc"
    }
			{fbvElement
        type="select"
        id="opensciencebadges-size"
        name="size"
        from=$sizes
        selected=$size|default:$defaultSize
        translate=false
        size=$fbvStyles.size.SMALL
      }
      <img src="{$pluginUrl}/images/example-size.png" alt="" />
		{/fbvFormSection}
		{fbvFormSection
      for="color"
      id="opensciencebadges-color-section"
      label="plugins.generic.openScienceBadges.settings.color"
      description="plugins.generic.openScienceBadges.settings.color.desc"
    }
			{fbvElement
        type="select"
        id="opensciencebadges-color"
        name="color"
        from=$colors
        selected=$color|default:$defaultColor
        translate=false
        size=$fbvStyles.size.SMALL
      }
      <img src="{$pluginUrl}/images/example-color.png" alt="" />
		{/fbvFormSection}
		{fbvFormSection
      for="location"
      id="opensciencebadges-location-section"
      label="plugins.generic.openScienceBadges.settings.location"
      description="plugins.generic.openScienceBadges.settings.location.desc"
    }
			{fbvElement
        type="select"
        id="opensciencebadges-location"
        name="location"
        from=$locations
        selected=$location|default:$defaultLocation
        translate=false
      }
		{/fbvFormSection}
	{/fbvFormArea}
	{fbvFormButtons submitText="common.save" hideCancel=true}
</form>
