import Box from '@mui/material/Box'
import Card from '@mui/material/Card'
import CardContent from '@mui/material/CardContent'
import Container from '@mui/material/Container'
import List from '@mui/material/List'
import ListItem from '@mui/material/ListItem'
import ListItemButton from '@mui/material/ListItemButton'
import ListItemText from '@mui/material/ListItemText'
import Typography from '@mui/material/Typography'
import { useRouter } from 'next/router'
import * as React from 'react'

export default function CompanyList() {
  const router = useRouter()

  // テストデータの作成
  const companyData = [
    { company_id: 1, company_name: '株式会社1番' },
    { company_id: 2, company_name: '株式会社2番' },
    { company_id: 3, company_name: '株式会社3番' },
    { company_id: 4, company_name: '株式会社4番です' },
  ]

  // ページ遷移を処理する関数
  const handleNavigation = (companyId) => () => {
    router.push(`/company/${companyId}`)
  }

  return (
    <Box sx={{ backgroundColor: 'white', minHeight: '100vh', p: 4 }}>
      <Typography
        variant="h3"
        component="h1"
        sx={{ textAlign: 'center', mb: 2 }}
      >
        オススメ会社一覧
      </Typography>
      <Typography
        variant="body1"
        component="p"
        sx={{ textAlign: 'center', mb: 4 }}
      >
        あなたが気になる会社を選ぼう
      </Typography>
      <Container maxWidth="md">
        <List
          sx={{
            width: '100%',
            bgcolor: 'background.paper',
            overflow: 'auto',
          }}
        >
          {companyData.map((company) => {
            const labelId = `company-list-label-${company.company_id}`

            return (
              <Card key={company.company_id} sx={{ mb: 4, p: 2 }}>
                <CardContent>
                  <ListItem disablePadding>
                    <ListItemButton
                      role={undefined}
                      onClick={handleNavigation(company.company_id)}
                      dense
                      sx={{ justifyContent: 'center' }} // 中央寄せ
                    >
                      <ListItemText
                        id={labelId}
                        primary={company.company_name}
                        sx={{ textAlign: 'center' }} // テキストの中央寄せ
                        primaryTypographyProps={{ variant: 'h6' }}
                      />
                    </ListItemButton>
                  </ListItem>
                </CardContent>
              </Card>
            )
          })}
        </List>
      </Container>
    </Box>
  )
}
