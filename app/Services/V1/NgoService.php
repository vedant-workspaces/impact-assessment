<?php

namespace App\Services\V1;

use App\Mail\NgoRegisteredMail;
use App\Repositories\Dao\V1\RegisterNgoDao;
use App\Repositories\Dao\V1\RegisterUserDao;
use App\Repositories\V1\NgosRepository;
use App\Repositories\V1\UsersRepository;
use App\Services\Bo\V1\RegisterNgoBo;
use Illuminate\Support\Facades\Mail;

class NgoService
{
    public function registerNgo(RegisterNgoBo $registerNgoBo)
    {
        try {
            $registerUserDao = $this->setRegisterUserDao($registerNgoBo);
    
            $registerNgoDao = $this->setRegisterNgoDao($registerNgoBo);
    
            $userId = app(UsersRepository::class)->insert($registerUserDao);
            $registerNgoDao->setUserId($userId);
    
            app(NgosRepository::class)->insert($registerNgoDao);

            // Send confirmation email
            Mail::to($registerNgoBo->getOrganisationEmail())
                ->send(new NgoRegisteredMail($registerNgoBo->getOrganisationName(), $registerNgoBo->getUserName())
            );
    
            return response()->json(['status' => 200, 'message' => 'NGO registered successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    private function setRegisterUserDao(RegisterNgoBo $registerNgoBo): RegisterUserDao
    {
        $registerUserDao = app(RegisterUserDao::class);
        $registerUserDao->setEmail($registerNgoBo->getOrganisationEmail());
        $registerUserDao->setUserName($registerNgoBo->getUserName());
        $registerUserDao->setPassword($registerNgoBo->getPassword());
        $registerUserDao->setUserType(1);

        return $registerUserDao;
    }

    private function setRegisterNgoDao(RegisterNgoBo $registerNgoBo): RegisterNgoDao
    {
        $registerNgoDao = app(RegisterNgoDao::class);
        $registerNgoDao->setOrganisationWebsite($registerNgoBo->getOrganisationWebsite());
        $registerNgoDao->setOrganisationName($registerNgoBo->getOrganisationName());
        $registerNgoDao->setContactPersonName($registerNgoBo->getContactPersonName());
        $registerNgoDao->setContactPersonDesignation($registerNgoBo->getContactPersonDesignation());
        $registerNgoDao->setContactPersonNumber($registerNgoBo->getContactPersonNumber());
        $registerNgoDao->setOrganisationAddress($registerNgoBo->getOrganisationAddress());
        $registerNgoDao->setOrganisationCity($registerNgoBo->getOrganisationCity());
        $registerNgoDao->setOrganisationState($registerNgoBo->getOrganisationState());
        $registerNgoDao->setOrganisationPincode($registerNgoBo->getOrganisationPincode());
        $registerNgoDao->setPrimarySectorIds(implode(',', $registerNgoBo->getPrimarySector()));
        $registerNgoDao->setSdgIds(implode(',', $registerNgoBo->getSdgs()));
        $registerNgoDao->setPurpose($registerNgoBo->getPurpose());

        return $registerNgoDao;
    }
}