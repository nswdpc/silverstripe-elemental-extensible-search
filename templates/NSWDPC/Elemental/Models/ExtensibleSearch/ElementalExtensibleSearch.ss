<% if $ShowTitle && $Title %>
    <<% if $HeadingLevel %>$HeadingLevel<% else %>h2<% end_if %>>
        {$Title}
    </<% if $HeadingLevel %>$HeadingLevel<% else %>h2<% end_if %>>
<% end_if %>

<% if $Subtitle %>
    <p>{$Subtitle.XML}</p>
<% end_if %>

<% if $ElementSearchForm %>
    $ElementSearchForm
<% end_if %>
<% if $SearchPage.Suggestions.filter('Approved', 1) %>
    <ul>
        <% loop $SearchPage.Suggestions.filter('Approved', 1) %>
            <li>{$Term}</li>
        <% end_loop %>
    </ul>
<% end_if %>
