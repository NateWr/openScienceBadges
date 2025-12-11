<div class="opensciencebadges opensciencebadges-lg">
  <div class="opensciencebadges-lg-badges">
    {foreach from=$osbBadges item="badge"}
      {if $badge.desc|@trim}
        <img src="{$badge.url}" alt="" />
      {/if}
    {/foreach}
  </div>
  <div class="opensciencebadges-lg-descs">
    {foreach from=$osbBadges item="badge"}
      {if $badge.desc|@trim}
        <p class="opensciencebadge-desc">
          <strong class="opensciencebadge-label">
            {translate key="plugins.generic.openScienceBadges.badgeTitleFormat" title=$badge.name}
          </strong>
          {$badge.desc|strip_unsafe_html}
        </p>
      {/if}
    {/foreach}
  </div>
</div>
