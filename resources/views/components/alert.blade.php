<div class="{{ isset($card) ? 'card-alert'.' ' : '' }}alert alert-{{ $type }}{{ isset($classes) ? ' '.$classes : '' }}" role="alert">
	@isset($title)
		<a href="{{ $url }}" class="alert-link">{{ $title }}</a>
	@endisset

	{{ $slot }}
</div>