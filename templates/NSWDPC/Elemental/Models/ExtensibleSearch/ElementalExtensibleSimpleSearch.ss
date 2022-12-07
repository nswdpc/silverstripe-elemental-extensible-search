<%-- basic template, override in your own project --%>

<% if $ShowTitle && $Title %>
    <<% if $HeadingLevel %>$HeadingLevel<% else %>h2<% end_if %>>
        {$Title}
    </<% if $HeadingLevel %>$HeadingLevel<% else %>h2<% end_if %>>
<% end_if %>

<% if $Content || $Image %>
<p>
<% if $Image %>
    {$Image.ScaleHeight(96)}
<% end_if %>
<% if $Content %>
    <span>{$Content}</span>
<% end_if %>
</p>
<% end_if %>


<% if $ElementSearchForm %>
    {$ElementSearchForm}
<% end_if %>
