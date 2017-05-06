<?php


class EmployerCest
{
    public function signIn(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('_username', 'microsoft@email.com');
        $I->fillField('_password', '123456');
        $I->click('Prisijunk');
        $I->see('Šiuo metu darbo ieško');
    }

    public function createNewJobAd(AcceptanceTester $I)
    {
        $this->signIn($I);
        $I->click('Veiksmai');
        $I->click('Sukurti naują skelbimą');
        $I->fillField('job_ad[title]', 'Frontend developer');
        $I->click('Pridėti reikalavimus');
        $I->fillField('requirement', 'React');
        $I->click('Pridėk');
        $I->click('x');
        $I->fillField('job_ad[assignment]', 'https://drive.google.com/drive/');
        $I->fillField('job_ad[description]', 'Perspektyvus darbas su puikiom perspektyvom.');
        $I->click('Sukurti');
        $I->see('FRONTEND DEVELOPER');
    }

    public function editEvaluation(AcceptanceTester $I)
    {
        $this->signIn($I);
        $I->click('Veiksmai');
        $I->click('Mano skelbimai');
        $I->click('Kandidatų į šią poziciją');
        $I->click('Redaguoti įvertinimą');
        $I->fillField('evaluation[mark]', '6');
        $I->fillField('evaluation[comment]', 'Yra kur pasitempti.');
        $I->click('Siųsti įvertinimą');
        $I->see('MANO ĮVERTINIMAS');
    }
}