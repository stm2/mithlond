<?php
use Illuminate\Database\Seeder;

class RulesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Rule::class)->create();
        factory(App\Rule::class)->create([
            'type' => 1,
            'name' => 'Eressea',
            'description' => "Eressea 2 orders",
            'options' => RulesTableSeeder::start_end_regexp()
        ]);
        factory(App\Rule::class)->create([
            'type' => 1,
            'name' => 'Regexp',
            'description' => "",
            'options' => RulesTableSeeder::regexp_replace()
        ]);
    }

    public static function regexp_replace()
    {
        return json_encode([
            'type' => 'REGEXP_COMPOSE',
            'replacers' => [
                [
                    'from' => '',
                    'to' => '(<comment><EOL>)*<<ERESSEA>><EOL>(<comment><EOL>)*((<<REGION>><comment>?<EOL>(<comment><EOL>)*)?<<EINHEIT>><comment>?<EOL>(<comment><EOL>)*(<<ORDER>><comment>?<EOL>|<comment><EOL>)*)*<<NÄCHSTER>>'
                ],
                [
                    'from' => '<<ERESSEA>>',
                    'to' => 'ERESSEA <id> <pw>'
                ],
                [
                    'from' => '<<REGION>>',
                    'to' => 'REGION <num0->,<num0->'
                ],
                [
                    'from' => '<<EINHEIT>>',
                    'to' => 'EINHEIT <id>'
                ],
                [
                    'from' => '<<ORDER>>',
                    'join' => '|',
                    'to' => [
                        'ARBEITE',
                        'LERNE <identifier>( <num>)'
                        // 'MACHE (<num> )?<identifier> <id>',
                        // 'MACHE (<num> )?<identifier>',
                        // 'MACHE (<num> )?straße <direction>',
                        // 'BENENNE EINHEIT <name>',
                        // 'BENENNE FREMDE EINHEIT <id> <name>',
                        // 'BENENNE PARTEI <name>',
                        // 'BENENNE FREMDE PARTEI <id> <name>',
                        // 'BENENNE GEBäUDE <name>',
                        // 'BENENNE FREMDES GEBäUDE <id> <name>',
                        // 'BENENNE SCHIFF <name>',
                        // 'BENENNE FREMDES SCHIFF <id> <name>',
                        // 'BENNENNE REGION <name>'
                    ]
                ],
                [
                    'from' => '<<NÄCHSTER>>',
                    'to' => 'NäCHSTER'
                ],
                [
                    'from' => '<id>',
                    'to' => '[1-9a-zA-Z][0-9a-zA-Z]{0,3}'
                ],
                [
                    'from' => '<num0->',
                    'to' => '-?<num>|<num0>'
                ],
                [
                    'from' => '<num>',
                    'to' => '[1-9][0-9]*'
                ],
                [
                    'from' => '<num0>',
                    'to' => '[0-9]([1-9][0-9]*)?'
                ],
                [
                    'from' => '<direction>',
                    'to' => 'NO|O|SO|SW|W|NW|NORDOSTEN|OSTEN|SüDOSTEN|SüDWESTEN|WESTEN|NORDWESTEN'
                ],
                [
                    'from' => 'ä',
                    'to' => 'ä|Ä|ae'
                ],
                [
                    'from' => 'ö',
                    'to' => 'ö|Ö|oe'
                ],
                [
                    'from' => 'ü',
                    'to' => 'ü|Ü|ue'
                ],
                [
                    'from' => 'ß',
                    'to' => 'ß|ss'
                ],
                [
                    'from' => ' ',
                    'to' => '[ ]+'
                ],
                [
                    'from' => '<identifier>',
                    'to' => '[a-zäöü]([a-zäöüß~]*[a-zäöüß])?|"[a-zäöü]([a-zäöüß ]*[a-zäöüß])?"'
                ],
                [
                    'from' => '<name>',
                    'to' => '"[^(){}[]\n]+"'
                ],
                [
                    'from' => '<name0>',
                    'to' => '"[^(){}[]\n]*"'
                ],
                [
                    'from' => '<comment>',
                    'to' => '[ ]*;.*'
                ],
                [
                    'from' => '<pw>',
                    'to' => '"[A-Za-z0-9]"'
                ],
                [
                    'from' => '<EOL>',
                    'to' => '[ ]*\n'
                ]
            ]
        ]);
    }

    public static function start_end_regexp()
    {
        return json_encode([
            'type' => 'START_END_REGEXP',
            'start' => [
                'regexp' => 'ERESSEA +[a-z1-9][a-z0-9]* +("[a-z0-9]+"|\'[a-z0-9]+\')[; ]*'
            ],
            'end' => [
                'regexp' => ' *N(AE|[Ää])CHSTER[ ;]*',
                'options' => 'iu' // FIXME: u is required to recognize the character class [Ä]
            ],
            'regexps' => [
                [
                    'regexp' => '[A-Za-zÄÖÜäöü]{2,}[; ].*',
                    'options' => 'iu'
                ],
                [
                    'regexp' => ' *(;.*)?'
                ]
            ]
        ]);
    }
}
