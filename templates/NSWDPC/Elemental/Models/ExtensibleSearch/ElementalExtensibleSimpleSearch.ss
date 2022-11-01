<% if $ElementSearchForm %>

    <% with $ElementSearchForm %>
    <div class="nsw-grid">

        <div class="nsw-col nsw-col-md-8">

            <form role="search" {$FormAttributes}>
                <% if $Up.ShowTitle && $Up.Title %>
                <label class="nsw-form__label" for="{$FormName}_Search">{$Up.Title}</label>
                <% end_if %>
                <div class="nsw-form__input-group">
                    <input id="{$FormName}_Search" name="Search" type="search" class="nsw-form__input" value="{$SearchQuery.XML}">
                    <button class="nsw-button nsw-button--dark nsw-button--flex" type="submit"><%t nswds.SEARCH 'Search' %></button>
                </div>
                <% if $HiddenFields %>
                    <% loop $HiddenFields %>
                    {$Field}
                    <% end_loop %>
                <% end_if %>
            </form>

        </div>

    </div>
    <% end_with %>

<% end_if %>
