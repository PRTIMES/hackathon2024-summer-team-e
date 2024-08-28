import IconButton from '@mui/material/IconButton'
import List from '@mui/material/List'
import ListItem from '@mui/material/ListItem'
import ListItemButton from '@mui/material/ListItemButton'
import ListItemText from '@mui/material/ListItemText'
import Typography from '@mui/material/Typography'
import { useRouter } from 'next/router' // useRouterをインポート
import * as React from 'react'

export default function CompanyList() {
  const router = useRouter() // useRouterを使用

  // テストデータの作成
  const companyData = [
    { id: 1, name: '株式会社1番' },
    { id: 2, name: '株式会社2番' },
    { id: 3, name: '株式会社3番' },
    { id: 4, name: '株式会社4番' },
  ]

  // ページ遷移を処理する関数
  const handleNavigation = (companyId) => () => {
    router.push(`/company/${companyId}`) // Ensure dynamic navigation based on the company ID
  }

  return (
    <List
      sx={{
        width: '100%',
        height: '100vh',
        bgcolor: 'background.paper',
        overflow: 'auto',
      }}
    >
      <Typography
        variant="h2"
        component="h1"
        sx={{ textAlign: 'center', marginY: 4 }}
      >
        会社一覧
      </Typography>
      {companyData.map((company) => {
        const labelId = `company-list-label-${company.id}`

        return (
          <ListItem
            key={company.id}
            secondaryAction={
              <IconButton edge="end" aria-label="comments"></IconButton>
            }
            disablePadding
          >
            <ListItemButton
              role={undefined}
              onClick={handleNavigation(company.id)}
              dense
            >
              <ListItemText
                id={labelId}
                primary={company.name}
                sx={{ textAlign: 'center' }}
                primaryTypographyProps={{ variant: 'h6' }} // Adjust font size here
              />
            </ListItemButton>
          </ListItem>
        )
      })}
    </List>
  )
}
