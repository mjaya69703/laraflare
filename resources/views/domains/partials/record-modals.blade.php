<!-- Add Record Modal -->
<div x-data="{ 
    open: false,
    recordType: 'A',
    showPriority: false,
    getContentPlaceholder() {
        switch(this.recordType) {
            case 'A': return '192.0.2.1';
            case 'AAAA': return '2001:db8:85a3::8a2e:370:7334';
            case 'CNAME': return 'hostname.example.com';
            case 'TXT': return 'v=spf1 include:_spf.example.com ~all';
            case 'MX': return 'mail.example.com';
            default: return '';
        }
    },
    getContentHelp() {
        switch(this.recordType) {
            case 'A': return 'Enter IPv4 address';
            case 'AAAA': return 'Enter IPv6 address';
            case 'CNAME': return 'Enter target hostname';
            case 'TXT': return 'Enter text record content';
            case 'MX': return 'Enter mail server hostname';
            default: return '';
        }
    }
}"
     x-show="open"
     x-on:open-modal.window="if ($event.detail === 'add-record') { open = true; recordType = 'A'; }"
     x-on:close-modal.window="open = false"
     x-on:keydown.escape.window="open = false"
     x-cloak
     class="fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="open"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
             @click="open = false">
        </div>

        <div x-show="open"
             class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <form action="{{ route('records.store', $domain['id']) }}" method="POST" onsubmit="showLoading()">
                @csrf
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Add DNS Record</h3>
                        <p class="mt-1 text-sm text-gray-500">Create a new DNS record for {{ $domain['name'] }}</p>
                    </div>

                    <div class="space-y-4">
                        <!-- Record Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Record Type</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <select x-model="recordType" 
                                        name="type" 
                                        class="flex-1 min-w-0 block w-full px-3 py-2 rounded-md focus:ring-orange-500 focus:border-orange-500 sm:text-sm border-gray-300">
                                    <option value="A">A - IPv4 Address</option>
                                    <option value="AAAA">AAAA - IPv6 Address</option>
                                    <option value="CNAME">CNAME - Canonical Name</option>
                                    <option value="TXT">TXT - Text Record</option>
                                    <option value="MX">MX - Mail Exchange</option>
                                </select>
                            </div>
                        </div>

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" 
                                       name="name" 
                                       class="flex-1 min-w-0 block w-full px-3 py-2 rounded-md focus:ring-orange-500 focus:border-orange-500 sm:text-sm border-gray-300"
                                       :placeholder="recordType === 'MX' ? 'example.com' : '@.example.com'"
                                       required>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Use @ for root domain</p>
                        </div>

                        <!-- Content -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Content</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" 
                                       name="content" 
                                       class="flex-1 min-w-0 block w-full px-3 py-2 rounded-md focus:ring-orange-500 focus:border-orange-500 sm:text-sm border-gray-300"
                                       :placeholder="getContentPlaceholder()"
                                       required>
                            </div>
                            <p class="mt-1 text-sm text-gray-500" x-text="getContentHelp()"></p>
                        </div>

                        <!-- Priority for MX -->
                        <div x-show="recordType === 'MX'">
                            <label class="block text-sm font-medium text-gray-700">Priority</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="number" 
                                       name="priority" 
                                       class="flex-1 min-w-0 block w-full px-3 py-2 rounded-md focus:ring-orange-500 focus:border-orange-500 sm:text-sm border-gray-300"
                                       placeholder="10"
                                       min="0"
                                       max="65535"
                                       value="10">
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Lower numbers have higher priority</p>
                        </div>

                        <!-- TTL -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">TTL</label>
                            <div class="mt-1">
                                <select name="ttl" 
                                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm rounded-md">
                                    <option value="1">Auto</option>
                                    <option value="60">1 minute</option>
                                    <option value="300">5 minutes</option>
                                    <option value="1800">30 minutes</option>
                                    <option value="3600">1 hour</option>
                                    <option value="7200">2 hours</option>
                                    <option value="86400">1 day</option>
                                </select>
                            </div>
                        </div>

                        <!-- Proxy Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Proxy Status</label>
                            <div class="mt-1">
                                <select name="proxied" 
                                        :disabled="['MX', 'TXT'].includes(recordType)"
                                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm rounded-md">
                                    <option value="1" x-bind:selected="!['MX', 'TXT'].includes(recordType)">Proxied</option>
                                    <option value="0" x-bind:selected="['MX', 'TXT'].includes(recordType)">DNS only</option>
                                </select>
                            </div>
                            <p class="mt-1 text-sm text-gray-500" x-show="['MX', 'TXT'].includes(recordType)">
                                Proxy cannot be enabled for this record type
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                    <button type="submit" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:col-start-2 sm:text-sm">
                        Add Record
                    </button>
                    <button type="button" 
                            @click="open = false" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Record Modal -->
@foreach($records as $record)
<div x-data="{ 
    open: false,
    recordType: '{{ $record['type'] }}',
    getContentPlaceholder() {
        switch(this.recordType) {
            case 'A': return '192.0.2.1';
            case 'AAAA': return '2001:db8:85a3::8a2e:370:7334';
            case 'CNAME': return 'hostname.example.com';
            case 'TXT': return 'v=spf1 include:_spf.example.com ~all';
            case 'MX': return 'mail.example.com';
            default: return '';
        }
    },
    getContentHelp() {
        switch(this.recordType) {
            case 'A': return 'Enter IPv4 address';
            case 'AAAA': return 'Enter IPv6 address';
            case 'CNAME': return 'Enter target hostname';
            case 'TXT': return 'Enter text record content';
            case 'MX': return 'Enter mail server hostname';
            default: return '';
        }
    }
}"
     x-show="open"
     x-on:open-modal.window="if ($event.detail === 'edit-record-{{ $record['id'] }}') { open = true; }"
     x-on:close-modal.window="open = false"
     x-on:keydown.escape.window="open = false"
     x-cloak
     class="fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="open"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
             @click="open = false">
        </div>

        <div x-show="open"
             class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <form action="{{ route('records.update', [$domain['id'], $record['id']]) }}" method="POST" onsubmit="showLoading()">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Edit DNS Record</h3>
                        <p class="mt-1 text-sm text-gray-500">Update DNS record for {{ $domain['name'] }}</p>
                    </div>

                    <div class="space-y-4">
                        <!-- Record Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Record Type</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <select x-model="recordType" 
                                        name="type" 
                                        class="flex-1 min-w-0 block w-full px-3 py-2 rounded-md focus:ring-orange-500 focus:border-orange-500 sm:text-sm border-gray-300">
                                    <option value="A" {{ $record['type'] === 'A' ? 'selected' : '' }}>A - IPv4 Address</option>
                                    <option value="AAAA" {{ $record['type'] === 'AAAA' ? 'selected' : '' }}>AAAA - IPv6 Address</option>
                                    <option value="CNAME" {{ $record['type'] === 'CNAME' ? 'selected' : '' }}>CNAME - Canonical Name</option>
                                    <option value="TXT" {{ $record['type'] === 'TXT' ? 'selected' : '' }}>TXT - Text Record</option>
                                    <option value="MX" {{ $record['type'] === 'MX' ? 'selected' : '' }}>MX - Mail Exchange</option>
                                </select>
                            </div>
                        </div>

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" 
                                       name="name" 
                                       value="{{ $record['name'] }}"
                                       class="flex-1 min-w-0 block w-full px-3 py-2 rounded-md focus:ring-orange-500 focus:border-orange-500 sm:text-sm border-gray-300"
                                       :placeholder="recordType === 'MX' ? 'example.com' : '@.example.com'"
                                       required>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Use @ for root domain</p>
                        </div>

                        <!-- Content -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Content</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" 
                                       name="content" 
                                       value="{{ $record['content'] }}"
                                       class="flex-1 min-w-0 block w-full px-3 py-2 rounded-md focus:ring-orange-500 focus:border-orange-500 sm:text-sm border-gray-300"
                                       :placeholder="getContentPlaceholder()"
                                       required>
                            </div>
                            <p class="mt-1 text-sm text-gray-500" x-text="getContentHelp()"></p>
                        </div>

                        <!-- Priority for MX -->
                        <div x-show="recordType === 'MX'">
                            <label class="block text-sm font-medium text-gray-700">Priority</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="number" 
                                       name="priority" 
                                       value="{{ $record['priority'] ?? 10 }}"
                                       class="flex-1 min-w-0 block w-full px-3 py-2 rounded-md focus:ring-orange-500 focus:border-orange-500 sm:text-sm border-gray-300"
                                       placeholder="10"
                                       min="0"
                                       max="65535">
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Lower numbers have higher priority</p>
                        </div>

                        <!-- TTL -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">TTL</label>
                            <div class="mt-1">
                                <select name="ttl" 
                                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm rounded-md">
                                    <option value="1" {{ $record['ttl'] === 1 ? 'selected' : '' }}>Auto</option>
                                    <option value="60" {{ $record['ttl'] === 60 ? 'selected' : '' }}>1 minute</option>
                                    <option value="300" {{ $record['ttl'] === 300 ? 'selected' : '' }}>5 minutes</option>
                                    <option value="1800" {{ $record['ttl'] === 1800 ? 'selected' : '' }}>30 minutes</option>
                                    <option value="3600" {{ $record['ttl'] === 3600 ? 'selected' : '' }}>1 hour</option>
                                    <option value="7200" {{ $record['ttl'] === 7200 ? 'selected' : '' }}>2 hours</option>
                                    <option value="86400" {{ $record['ttl'] === 86400 ? 'selected' : '' }}>1 day</option>
                                </select>
                            </div>
                        </div>

                        <!-- Proxy Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Proxy Status</label>
                            <div class="mt-1">
                                <select name="proxied" 
                                        :disabled="['MX', 'TXT'].includes(recordType)"
                                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm rounded-md">
                                    <option value="1" {{ $record['proxied'] ? 'selected' : '' }}>Proxied</option>
                                    <option value="0" {{ !$record['proxied'] ? 'selected' : '' }}>DNS only</option>
                                </select>
                            </div>
                            <p class="mt-1 text-sm text-gray-500" x-show="['MX', 'TXT'].includes(recordType)">
                                Proxy cannot be enabled for this record type
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                    <button type="submit" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:col-start-2 sm:text-sm">
                        Update Record
                    </button>
                    <button type="button" 
                            @click="open = false" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach 