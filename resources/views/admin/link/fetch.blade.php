@foreach($links as $link)
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
@endforeach
