@extends('admin.template')

@section('meta')
    <title>Tiny Admin</title>
@endsection

@section('content')
<div class="content-padder content-background">
    <br>
    <div class="uk-container uk-background-default uk-padding-large" style="margin: 10px !important;">
        <div class="uk-container uk-margin-small" uk-margin>
            <form method="get">
            <!-- @csrf -->
            <div class="uk-margin" uk-margin>
                <fieldset class="uk-fieldset">
                    @if(isset($error))
                        <span class="uk-text-meta uk-text-danger">Try changing search type.</span>
                    @endif
                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                        <label><input class="uk-radio" type="radio" name="find_by" value="id" checked> ID</label>
                        <label><input class="uk-radio" type="radio" name="find_by" value="tiny"> Tiny</label>
                    </div>
                    <div class="uk-margin">
                        <input type="text" class="uk-input " name="link" placeholder="Place id or tiny.">
                    </div>
                    <div class="uk-margin">
                        <button class="uk-button uk-button-primary">Find</button>
                    </div>
                </fieldset>
            </div>
            </form>

            @if(isset($_GET['link']))
                @if(isset($link) && !is_null($link))
                    {{--starts in here--}}
                    <table class="uk-table uk-table-hover uk-table-divider">
                    <style>
                        thead > tr > th {
                            text-align: left !important;
                        }
                    </style>
                    <thead>
                    <tr>
                        <th>URL</th>
                        <th>TLD</th>
                        <th>TINY</th>
                        <th>VIEWS</th>
                        <th>STATE</th>
                        <th>IP</th>
                        <th>Registered_AT</th>
                        <th>DEACTIVATE</th>
                        <th>DELETE</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $link->url }}</td>
                        <td>{{ $link->tld }}</td>
                        <td><a href="{{ route('Link > Redirect', $link->tiny) }}">{{ $link->tiny }}</a></td>
                        <td>{{ $link->views }}</td>
                        <td>{{ $link->state }}</td>
                        <td>{{ $link->ip }}</td>
                        <td>{{ $link->registered_at }}</td>
                        <td>
                            @if($link->state)
                                <button type="submit" class="uk-button uk-button-secondary uk-button-small" uk-toggle="target: #deactivate_{{ $link->id }}">Deactivate</button>
                                <div id="deactivate_{{ $link->id }}" uk-modal>
                                    <div class="uk-modal-dialog uk-modal-body">
                                        <h2 class="uk-modal-title">Operation confirmation</h2>
                                        <p>
                                            You're going to <span class="uk-text-danger">deactivate</span> this link. are you sure?
                                        </p>
                                        <form action="{{ route('Admin > Links > Deactivate', $link->id) }}" method="post">
                                            @csrf
                                            <p class="uk-text-right">
                                                <input type="hidden" name="id" value="{{ $link->id }}">
                                                <button class="uk-button uk-button-default uk-modal-close">cancel</button>
                                                <button class="uk-button uk-button-primary" type="submit">yes</button>
                                            </p>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <button type="submit" class="uk-button uk-button-default uk-button-small" uk-toggle="target: #activate_{{ $link->id }}">Activate</button>
                                <div id="activate_{{ $link->id }}" uk-modal>
                                    <div class="uk-modal-dialog uk-modal-body">
                                        <h2 class="uk-modal-title">Operation confirmation</h2>
                                        <p>
                                            You're going to <span class="uk-text-primary">activate</span> this link. are you sure?
                                        </p>
                                        <form action="{{ route('Admin > Links > Activate', $link->id) }}" method="post">
                                            @csrf
                                            <p class="uk-text-right">
                                                <input type="hidden" name="id" value="{{ $link->id }}">
                                                <button class="uk-button uk-button-default uk-modal-close">cancel</button>
                                                <button class="uk-button uk-button-primary" type="submit">yes</button>
                                            </p>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td>
                            <button type="submit" class="uk-button uk-button-danger uk-button-small" uk-toggle="target: #delete_{{ $link->id }}">Delete</button>
                            <div id="delete_{{ $link->id }}" uk-modal>
                                <div class="uk-modal-dialog uk-modal-body">
                                    <h2 class="uk-modal-title">Operation confirmation</h2>
                                    <p>
                                        You're going to <span class="uk-text-danger">delete</span> this link. are you sure? <br>
                                    <div class="uk-alert uk-alert-danger">
                                        action is not restorable.
                                    </div>
                                    </p>
                                    <form action="{{ route('Admin > Links > Delete', $link->id) }}" method="post">
                                        @csrf
                                        <p class="uk-text-right">
                                            <input type="hidden" name="id" value="{{ $link->id }}">
                                            <button class="uk-button uk-button-default uk-modal-close">cancel</button>
                                            <button class="uk-button uk-button-primary" type="submit">yes</button>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                    </table>
                    {{--ends in here--}}
                @else
                    <div class="uk-alert uk-alert-warning">
                        <p>
                            Unregistered link. <br>
                        </p>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
