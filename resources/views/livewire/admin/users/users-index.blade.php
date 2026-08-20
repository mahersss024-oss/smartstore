<div class="w-full">
    <x-page-header
        title="Users"
        description="Manage your users"
    />

    <flux:table :paginate="$users">
        <flux:table.columns>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Display Name</flux:table.column>
            <flux:table.column>Email</flux:table.column>
            <flux:table.column>Email Verified</flux:table.column>
            <flux:table.column>Domain</flux:table.column>
            <flux:table.column>Domain Verified</flux:table.column>
            <flux:table.column>Created</flux:table.column>
            <flux:table.column>Actions</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach($users as $user)
                <flux:table.row>
                    <flux:table.cell>{{ $user->name }}</flux:table.cell>
                    <flux:table.cell>{{ $user->display_name }}</flux:table.cell>
                    <flux:table.cell>{{ $user->email }}</flux:table.cell>
                    <flux:table.cell>
                        @if($user->email_verified_at)
                            <flux:icon.check-circle class="text-green-600 dark:text-green-500"/>
                        @else
                            <flux:icon.x-circle class="text-red-600 dark:text-red-500"/>
                        @endif
                    </flux:table.cell>
                    <flux:table.cell>{{ $user->domain?->name ?? '-' }}</flux:table.cell>
                    <flux:table.cell>
                        @if(\App\Helpers\DomainHelper::isVerifiedDomain($user->domain))
                            <flux:icon.check-circle class="text-green-600 dark:text-green-500"/>
                        @else
                            <flux:icon.x-circle class="text-red-600 dark:text-red-500"/>
                        @endif
                    </flux:table.cell>
                    <flux:table.cell>{{ $user->created_at->diffForHumans() }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:button
                            href="{{ \App\Helpers\DomainHelper::getDomainUrl($user->domain, $user->username) }}"
                            target="_blank"
                            variant="primary"
                            size="sm"
                            class="mr-2"
                        >
                            <flux:icon name="arrow-up-right" class="size-3"/>
                            View
                        </flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
