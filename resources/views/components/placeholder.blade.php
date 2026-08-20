@props(['fillClass' => 'fill-accent/15 dark:fill-zinc-600', 'strokeClass' => 'stroke-white dark:stroke-zinc-400'])

<div {{ $attributes->merge(['class' => 'rounded-md bg-accent/15 dark:bg-zinc-600 text-white dark:text-zinc-400']) }}>
    <svg  viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" class="{{ $fillClass }} {{ $strokeClass }}">
        <!-- Radial lines (shortened but still touch center circle) -->
        <line x1="512" y1="100" x2="512" y2="364" stroke-width="4"/>
        <line x1="512" y1="660" x2="512" y2="924" stroke-width="4"/>
        <line x1="100" y1="512" x2="364" y2="512" stroke-width="4"/>
        <line x1="660" y1="512" x2="924" y2="512" stroke-width="4"/>

        <!-- Diagonal lines (also shortened equally) -->
        <line x1="200" y1="200" x2="406" y2="406" stroke-width="4"/>
        <line x1="618" y1="618" x2="824" y2="824" stroke-width="4"/>
        <line x1="200" y1="824" x2="406" y2="618" stroke-width="4"/>
        <line x1="618" y1="406" x2="824" y2="200" stroke-width="4"/>

        <!-- Center circle -->
        <circle cx="512" cy="512" r="148" stroke-width="4"/>

        <g transform="translate(512 512) scale(0.7) translate(-128 -128)">
            <path fill="currentColor" stroke="currentColor" d="M168.00049,100.00012v.00342a12.00171,12.00171,0,1,1,0-.00342Zm63.999-44V199.99963a16.01833,16.01833,0,0,1-16,16h-176a16.01833,16.01833,0,0,1-16-16V56.00012a16.01834,16.01834,0,0,1,16-16h176A16.01833,16.01833,0,0,1,231.99951,56.00012Zm-15.9917,108.6933-.0083-108.6933h-176v92.68549L76.686,112.00012a16.019,16.019,0,0,1,22.62792,0l44.68653,44.68652L164.686,136.00012a16.019,16.019,0,0,1,22.62792,0Z"/>
        </g>
    </svg>
</div>

