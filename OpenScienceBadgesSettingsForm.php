<?php
namespace APP\plugins\generic\openScienceBadges;

use APP\core\Application;
use APP\template\TemplateManager;
use PKP\form\Form;
use PKP\form\validation\FormValidatorCSRF;
use PKP\form\validation\FormValidatorCustom;
use PKP\form\validation\FormValidatorPost;

class OpenScienceBadgesSettingsForm extends Form {

	public OpenScienceBadgesPlugin $plugin;

	public function __construct(OpenScienceBadgesPlugin $plugin)
    {
		$this->plugin = $plugin;

        parent::__construct($plugin->getTemplateResource('settings-form.tpl'));

		$this->addCheck(new FormValidatorPost($this));
		$this->addCheck(new FormValidatorCSRF($this));
		$this->addCheck(new FormValidatorCustom(
            $this,
            $this->plugin::SETTING_SIZE,
            'required',
            'validator.required',
            [$this, 'isSizeValid']
        ));
		$this->addCheck(new FormValidatorCustom(
            $this,
            $this->plugin::SETTING_COLOR,
            'required',
            'validator.required',
            [$this, 'isColorValid']
        ));
		$this->addCheck(new FormValidatorCustom(
            $this,
            $this->plugin::SETTING_LOCATION,
            'required',
            'validator.required',
            [$this, 'isLocationValid']
        ));
	}

    public function initData()
    {
		$context = Application::get()->getRequest()->getContext();
        if (!$context) {
            return;
        }
        $this->setData($this->plugin::SETTING_SIZE, $this->plugin->getSetting($context->getId(), $this->plugin::SETTING_SIZE));
        $this->setData($this->plugin::SETTING_COLOR, $this->plugin->getSetting($context->getId(), $this->plugin::SETTING_COLOR));
        $this->setData($this->plugin::SETTING_LOCATION, $this->plugin->getSetting($context->getId(), $this->plugin::SETTING_LOCATION));
    }

	public function readInputData()
    {
        $this->readUserVars([
            $this->plugin::SETTING_SIZE,
            $this->plugin::SETTING_COLOR,
            $this->plugin::SETTING_LOCATION,
        ]);
	}

	public function fetch($request, $template = null, $display = false)
    {
		$templateMgr = TemplateManager::getManager($request);
		$templateMgr->assign([
            'sizes' => [
                $this->plugin::SIZE_SMALL => __('plugins.generic.openScienceBadges.settings.size.small'),
                $this->plugin::SIZE_LARGE => __('plugins.generic.openScienceBadges.settings.size.large'),
            ],
            'colors' => [
                $this->plugin::COLOR_GRAY => __('plugins.generic.openScienceBadges.settings.color.gray'),
                $this->plugin::COLOR_COLOR => __('plugins.generic.openScienceBadges.settings.color.color'),
            ],
            'locations' => [
                $this->plugin::LOCATION_DETAILS => __('plugins.generic.openScienceBadges.settings.location.details'),
                $this->plugin::LOCATION_MAIN => __('plugins.generic.openScienceBadges.settings.location.main'),
                $this->plugin::LOCATION_NONE => __('plugins.generic.openScienceBadges.settings.location.none'),
            ],
            'pluginName' => $this->plugin->getName(),
            'pluginUrl' => $this->plugin->getPluginUrl(),
            'settingSize' => $this->plugin::SETTING_SIZE,
            'settingColor' => $this->plugin::SETTING_COLOR,
            'settingLocation' => $this->plugin::SETTING_LOCATION,
            'defaultSize' => $this->plugin::DEFAULT_SIZE,
            'defaultColor' => $this->plugin::DEFAULT_COLOR,
            'defaultLocation' => $this->plugin::DEFAULT_LOCATION,
        ]);
		return parent::fetch($request, $template, $display);
	}

	public function execute(...$functionArgs) {
		$context = Application::get()->getRequest()->getContext();
        if (!$context) {
            return;
        }

		$this->plugin->updateSetting(
            $context->getId(),
            $this->plugin::SETTING_SIZE,
            $this->getData($this->plugin::SETTING_SIZE)
        );
		$this->plugin->updateSetting(
            $context->getId(),
            $this->plugin::SETTING_COLOR,
            $this->getData($this->plugin::SETTING_COLOR)
        );
		$this->plugin->updateSetting(
            $context->getId(),
            $this->plugin::SETTING_LOCATION,
            $this->getData($this->plugin::SETTING_LOCATION)
        );

		parent::execute(...$functionArgs);
	}

    public function isSizeValid(string $size): bool
    {
        return in_array($size, $this->plugin::SIZES);
    }

    public function isColorValid(string $color): bool
    {
        return in_array($color, $this->plugin::COLORS);
    }

    public function isLocationValid(string $location): bool
    {
        return in_array($location, $this->plugin::LOCATIONS);
    }
}
