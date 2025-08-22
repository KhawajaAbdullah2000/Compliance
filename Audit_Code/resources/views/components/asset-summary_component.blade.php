<div class="col-md-8 mt-4">
    <div class="table-responsive">
        <table class="table table-bordered text-nowrap align-middle mb-0">
            <tbody>
                <tr class="fw-bold text-white">
                    <td class="bg-light_blue">Service</td>
                    <td class=" w-15">{{$asset->s_name}}</td>
                    <td class="bg-light_blue">Asset Type</td>
                    <td class="bg-light w-15">{{$asset->g_name}}</td>
                    <td class="bg-light_blue">Asset Sub Type</td>
                    <td class="bg-light">{{$asset->name}}</td>
                    
                     <td class="bg-light_blue">Asset Component</td>
                     <td class="bg-light_green">{{$asset->c_name}}</td>
                     
                    
                    {{-- <td class="bg-light_blue">Service Risk Owner</td>
                    <td class="bg-light">{{$asset->service_risk_owner_name}}</td>
                    <td class="bg-light_blue">Component Risk Owner</td>
                    <td class="bg-light">{{$asset->component_risk_owner_name}}</td>
                    <td class="bg-light_blue">Service Custodian</td>
                    <td class="bg-light">{{$asset->service_custodian_name}}</td>
                    <td class="bg-light_blue">Asset Component Custodian</td>
                    <td class="bg-light">{{$asset->component_custodian_name}}</td>   --}}
                    

                </tr>
            </tbody>
        </table>
    </div>
</div>