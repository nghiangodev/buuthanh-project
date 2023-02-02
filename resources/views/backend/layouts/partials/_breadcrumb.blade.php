@if(isset($model))
    {{ Breadcrumbs::render($breadcrumb, ['model' => $model, 'label' => $label ?? null, 'options' => $options ?? null]) }}
@else
    {{ Breadcrumbs::render($breadcrumb, $label ?? null) }}
@endif