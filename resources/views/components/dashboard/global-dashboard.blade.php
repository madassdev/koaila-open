@props(['saleFunnel','dropOffData','waumauData','daumauData','ttl','featureAdoption'])

@if($waumauData || $daumauData || $ttl || $featureAdoption )
    <div class="grid lg:grid-cols-2 md:grid-cols-1 gap-4" id="dashboard">
        @if($featureAdoption)
            <div class="bg-white rounded mt-4">
                <div class="p-4">
                    <h1 class="text-lg font-semibold text-gray-900 mb-4 text-center">Feature adoption (%)</h1>
                    <bar-chart
                        :data= '{!!json_encode($featureAdoption->data)!!}'
                        label= "Feature adoption"
                        backgroundcolor= "#ad74ce"
                        :limit='2'
                        :legend='true'
                    ></bar-chart>

                    <div class="flex justify-end">
                        <button onclick="document.getElementById('featureAdoptionModal').hidden=false; body.style.overflow = 'hidden';" class="text-blue-600 hover:text-blue-700" >See more</button>
                    </div>
                    <div id="featureAdoptionModal" hidden onclick="document.getElementById('featureAdoptionModal').hidden=true; body.style.overflow = 'auto'" class="fixed inset-0 bg-white bg-opacity-50 overflow-y-auto h-full w-full">
                        <div class="relative top-20 mx-auto p-5 border shadow-lg rounded-md bg-white w-1/2">
                            <div class="flex justify-end">
                                <button onclick="document.getElementById('featureAdoptionModal').hidden=true; body.style.overflow = 'auto'" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">Close</button>
                            </div>
                            <h1 class="text-lg font-semibold text-gray-900 mb-4 text-center">Feature adoption (%)</h1>
                            <bar-chart
                                :data= '{!!json_encode($featureAdoption->data)!!}'
                                label= "Feature adoption"
                                backgroundcolor= "#ad74ce"
                                :legend='true'
                            ></bar-chart>
                        </div>
                    </div>

                </div>
            </div>
        @endif

        @if($ttl)
            <div class="bg-white rounded mt-4">
                <div class="p-4">
                    <h1 class="text-lg font-semibold text-gray-900 mb-4 text-center">Time to value (in minutes)</h1>
                    <line-chart
                        :data= '{!!json_encode($ttl->data)!!}'
                        label= "Time to Value"
                        backgroundcolor= "#4778e9"
                    ></line-chart>
                </div>
            </div>
        @endif

        @if($daumauData)
            <div class="bg-white rounded mt-4">
                <div class="p-4">
                    <h1 class="text-lg font-semibold text-gray-900 mb-4 text-center">DAU/MAU (%)</h1>
                    <line-chart
                        :data= '{!!json_encode($daumauData->data)!!}'
                        label= "DAU/MAU"
                        backgroundcolor= "#8d75c9"
                    ></line-chart>
                </div>
            </div>
        @endif

        @if($waumauData)
            <div class="bg-white rounded mt-4">
                <div class="p-4">
                    <h1 class="text-lg font-semibold text-gray-900 mb-4 text-center">WAU/MAU (%)</h1>
                    <line-chart
                        :data= '{!!json_encode($waumauData->data)!!}'
                        label= "WAU/MAU"
                        backgroundcolor= "#8d75cf"
                    ></line-chart>
                </div>
            </div>
        @endif

    </div>
@endif
