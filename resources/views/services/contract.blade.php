<contract service-id="{{ $service->seq_id }}"
            service-contract-url="{{ url('servicecontracts').'/' }}"
            :currencies="{{ json_encode(config('constants.currencies')) }}">
</contract>
